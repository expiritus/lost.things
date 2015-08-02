<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 17.07.15
 * Time: 9:22
 */

namespace LostThings\MainBundle\Controller;


use LostThings\AdminBundle\Entity\Area;
use LostThings\AdminBundle\Entity\Lost;
use LostThings\AdminBundle\Entity\Street;
use LostThings\AdminBundle\Entity\Thing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LostController extends Controller{

    public function indexAction(Request $request){
        $user = $this->getUser();
        if(!$user){
            return $this->redirect('/login');
        }
        $countries = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Country')->findAll();

        return $this->render('LostThingsMainBundle:lost:index.html.twig', array(
            'countries' => $countries,
        ));
    }


    // Сюда приходит ajax запрос на выборку города по id
    public function getCityAction(Request $request){
        $id = $request->request->get('country_id');
        $city = $this->getDoctrine()->getRepository('LostThingsAdminBundle:City')->getCityById($id);
        $response = new Response(json_encode($city));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    // Сюда приходит ajax запрос на выборку района по id
    public function getAreaAction(Request $request){
        $id = $request->request->get('city_id');
        $area = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Area')->getAreaById($id);
        $response = new Response(json_encode($area));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }



    // Сюда приходит ajax запрос на выборку улицы по id
    public function getStreetAction(Request $request){
        $city_id = $request->request->get('city_id');
        $area = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Street')->getStreetById($city_id);
        $response = new Response(json_encode($area));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    // Сюда приходит ajax запрос на выборку базовых вещей
    public function getThingAction(Request $request){
        $thing = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Thing')->getBaseThing();
        $response = new Response(json_encode($thing));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    // Сохранение формы в базу
    public function saveLostThingAction(Request $request)
    {
        // Записываем в переменные значения из POST
        $country_id = $request->request->get('country');
        $city_id = $request->request->get('city');

        // Приводим к общему формату введенное назавание района или области
        $area_request = $request->request->get('area');
        if(!empty($area_request)){
            $first = mb_strtoupper(mb_substr($area_request, 0, 1));
            $last = mb_substr($area_request, 1);
            $last = mb_strtolower($last);
            $area_request = $first.$last;
            $area_request = trim($area_request);
            if(mb_strpos($area_request, ' ')){
                $postfix = mb_substr($area_request, mb_strpos($area_request, ' '));
                $area_request = mb_substr($area_request, 0, mb_strpos($area_request, ' '));
                $postfix = trim($postfix);
                switch(mb_substr($postfix, 0, 1)){
                    case 'р': $right_postfix = ' район';
                        break;
                    case 'о': $right_postfix = ' область';
                        break;
                    default: $right_postfix = ' район';
                }
            }else{
                $right_postfix = ' район';
            }
            $area_request = $area_request.$right_postfix;
        }


        // Приводим к общему формату введенное название улицы
        $street_request = $request->request->get('street');
        if(!empty($street_request)){
            $first = mb_strtoupper(mb_substr($street_request, 0, 1));
            $last = mb_substr($street_request, 1);
            $last = mb_strtolower($last);
            $street_request = $first.$last;
            $street_request = trim($street_request);
            if(mb_strpos($street_request, ' ')){
                $postfix = mb_substr($street_request, mb_strpos($street_request, ' '));
                $street_request = mb_substr($street_request, 0, mb_strpos($street_request, ' '));
                $postfix = trim($postfix);
                switch(mb_substr($postfix, 0, 1)){
                    case 'у': $right_postfix = ' улица';
                        break;
                    case 'п': $right_postfix = ' проспект';
                        break;
                    default: $right_postfix = ' улица';
                }
            }else{
                $right_postfix = ' улица';
            }

            $street_request = $street_request.$right_postfix;
        }

        $thing_request = $request->request->get('thing');
        if($thing_request == null){
            $thing_request = 0;
        }

        // Делаем первую букву вещи заглавной для сохранение в базе
        $other_thing_request = $request->request->get('other_thing');
        $first = mb_strtoupper(mb_substr($other_thing_request, 0, 1));
        $last = mb_substr($other_thing_request, 1);
        $other_thing_request = $first.$last;

        $description_request = $request->request->get('description');

        $lost_foto = $request->files->get('lost_foto');
        $dir = $this->get('kernel')->getRootDir().'/../web/files';
        if(isset($lost_foto)){
            $original_file_name = $lost_foto->getClientOriginalName();
            $mime_type = substr($original_file_name, strpos($original_file_name, '.'));
            $file_name = uniqid().$mime_type;
            $lost_foto->move($dir, $file_name);
        }



        /**
         * Если поле Район не пустое то проверяем есть ли эдентичное название района в базе
         * Если нет, то сохраняем в базу новое название района
         * Иначе выбираем из базы записи и перебираем все идентичные запросу записи и записываем в массив и возвращаем их в автокомплит через js и html5
         * Далее проверяем есть ли в массиве id идентичное id из запроса и возвращаем ключ
         * Записываем в таблицу area id города
         */
        if(!empty($area_request)){
            $lost_area = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Area')->findBy(array('area' => $area_request));
            if(!$lost_area) {
                $area = new Area();
                $city = $this->getDoctrine()->getRepository('LostThingsAdminBundle:City')->find($city_id);
                $city->getId();
                $area->setArea($area_request);
                $area->setCity($city);
                $em = $this->getDoctrine()->getManager();
                $em->persist($area);
                $em->flush();
                $area_id = $area->getId();
            }else{
                for($i=0; $i<count($lost_area); $i++){
                    $city_id_arr = [
                        $lost_area[$i]->getCityId()
                    ];
                }
                $key_city = array_search($city_id, $city_id_arr);
                if($lost_area[0]->getArea() != $area_request or $city_id_arr[$key_city] != (int)$city_id){
                    $area = new Area();
                    $city = $this->getDoctrine()->getRepository('LostThingsAdminBundle:City')->find($city_id);
                    $city->getId();
                    $area->setArea($area_request);
                    $area->setCity($city);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($area);
                    $em->flush();
                    $area_id = $area->getId();
                }else{
                    $area_id = $lost_area[0]->getId();
                }
            }
        }


        /**
         * Все тоже самое проделываем и с улицами города
         *
         * Если поле Улица не пустое то проверяем есть ли эдентичное название района в базе
         * Если нет, то сохраняем в базу новое название улицы
         * Иначе выбираем из базы записи и перебираем все идентичные запросу записи и записываем в массив и возвращаем их в автокомплит через js и html5
         * Далее проверяем есть ли в массиве id идентичное id из запроса и возвращаем ключ
         *
         * Записываем в таблицу street id города
         */
        if(!empty($street_request)){
            $lost_street = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Street')->findBy(array('street' => $street_request));
            if(!$lost_street){
                $street = new Street();
                $city_parent = $this->getDoctrine()->getRepository('LostThingsAdminBundle:City')->find($city_id);
                $city_parent->getId();
                $street->setCity($city_parent);

                $street->setStreet($street_request);

                $em = $this->getDoctrine()->getManager();
                $em->persist($street);
                $em->flush();
                $street_id = $street->getId();
            }else{
                for($i=0; $i<count($lost_street); $i++){
                    $street_id_arr = [
                        $lost_street[$i]->getCityId()
                    ];
                }

                $key_street = array_search($city_id, $street_id_arr);

                if($lost_street[0]->getStreet() != $street_request or $street_id_arr[$key_street] != (int)$city_id){
                    $street = new Street();
                    $city_parent = $this->getDoctrine()->getRepository('LostThingsAdminBundle:City')->find($city_id);
                    $city_parent->getId();
                    $street->setCity($city_parent);
                    $street->setStreet($street_request);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($street);
                    $em->flush();
                    $street_id = $street->getId();
                }else{
                    $street_id = $lost_street[0]->getId();
                }
            }
        }

        /**
         * Если поле "Другое" для вещи не пустое, то записываем его в базу как новая вещь
         * для автокомплита и присваиваем ему "base_thing = 0"
         */
        if(!empty($other_thing_request)){
            $thing_name = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Thing')->findBy(array('nameThing' => $other_thing_request));
            if(count($thing_name) > 0){
                if($thing_name[0]->getNameThing() != $other_thing_request){
                    $thing = new Thing();
                    $thing->setNameThing($other_thing_request);
                    $thing->setBaseThing(0);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($thing);
                    $em->flush();
                    $thing_id = $thing->getId();
                }else{
                    $thing_id = $thing_name[0]->getId();
                }
            }else{
                $thing = new Thing();
                $thing->setNameThing($other_thing_request);
                $thing->setBaseThing(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($thing);
                $em->flush();
                $thing_id = $thing->getId();
            }
        }else{
            $thing = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Thing')->find($thing_request);
            if(count($thing) > 0){
                $thing_id = $thing->getId();
            }
        }


        /**
         * Сохраняем все в таблицу lost
         */
        $lost = new Lost();

        $country = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Country')->find($country_id);
        $country->getId();

        $city = $this->getDoctrine()->getRepository('LostThingsAdminBundle:City')->find($city_id);
        if($city){
            $city->getId();
        }

        if(isset($area_id)){
            $area = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Area')->find($area_id);
            $area->getId();
        }

        if(isset($street_id)){
            $street = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Street')->find($street_id);
            $street->getId();
        }

        $user = $this->getUser();

        if(isset($thing_id)){
            $thing = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Thing')->find($thing_id);
            $thing->getId();
        }

        $lost->setCountry($country);
        $lost->setCity($city);
        if(isset($area)){
            $lost->setArea($area);
        }

        if(isset($street)){
            $lost->setStreet($street);
        }

        $lost->setUsername($user);

        if(isset($thing)){
            $lost->setThing($thing);
        }

        $lost->setStatus(0);
        $lost->setDescription($description_request);

        if(isset($file_name)){
            $lost->setFileName($file_name);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($lost);
        $em->flush();
        $id = $lost->getId();

        return $this->redirect('/lost/search/'.$id);
    }

}