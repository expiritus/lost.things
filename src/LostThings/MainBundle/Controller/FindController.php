<?php

namespace LostThings\MainBundle\Controller;

use LostThings\AdminBundle\Entity\Find;
use LostThings\AdminBundle\Entity\Country;
use LostThings\AdminBundle\Entity\City;
use LostThings\AdminBundle\Entity\Area;
use LostThings\AdminBundle\Entity\Street;
use LostThings\AdminBundle\Entity\Thing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FindController extends Controller
{

    public function indexAction(Request $request){
        $user = $this->getUser();
        if(!$user){
            return $this->redirect('/register');
        }
        $countries = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Country')->findAll();

        return $this->render('LostThingsMainBundle:find:index.html.twig', array(
            'countries' => $countries,
        ));
    }



    public function getCityAction(Request $request){
        $id = $request->request->get('country_id');
        $city = $this->getDoctrine()->getRepository('LostThingsAdminBundle:City')->getCityById($id);
        $response = new Response(json_encode($city));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getAreaAction(Request $request){
        $id = $request->request->get('city_id');
        $area = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Area')->getAreaById($id);
        $response = new Response(json_encode($area));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }



    public function getStreetAction(Request $request){
        $id = $request->request->get('area_id');
        $area = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Street')->getStreetById($id);
        $response = new Response(json_encode($area));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getThingAction(Request $request){
        $thing = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Thing')->getBaseThing();
        $response = new Response(json_encode($thing));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    public function saveFindThingAction(Request $request)
    {
        $city_id = $request->request->get('city');
        $area_request = $request->request->get('area');
        $street_request = $request->request->get('street');
        $thing_request = $request->request->get('thing');
        $other_thing_request = $request->request->get('other_thing');

        if(!empty($area_request)){
            $find_area = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Area')->findBy(array('area' => $area_request));
            if(!$find_area) {
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
                for($i=0; $i<count($find_area); $i++){
                    $city_id_arr = [
                        $find_area[$i]->getCityId()
                    ];
                }
                $key_city = array_search($city_id, $city_id_arr);
                if($find_area[0]->getArea() != $area_request or $city_id_arr[$key_city] != (int)$city_id){
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
                    $area_id = $find_area[0]->getId();
                }
            }

        }

        if(!empty($street_request)){
            $find_street = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Street')->findBy(array('street' => $street_request));
            if(!$find_street){
                $street = new Street();
                $area_parent = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Area')->find($area_id);
                $area_parent->getId();
                $street->setStreet($street_request);
                $street->setArea($area_parent);
                $em = $this->getDoctrine()->getManager();
                $em->persist($street);
                $em->flush();
                $street_id = $street->getId();
            }else{
                for($i=0; $i<count($find_street); $i++){
                    $street_id_arr = [
                        $find_street[$i]->getAreaId()
                    ];
                }
                $key_street = array_search($area_id, $street_id_arr);
                if($find_street[0]->getStreet() != $street_request or $street_id_arr[$key_street] != (int)$area_id){
                    $street = new Street();
                    $area_parent = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Area')->find($area_id);
                    $area_parent->getId();
                    $street->setStreet($street_request);
                    $street->setArea($area_parent);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($street);
                    $em->flush();
                    $street_id = $street->getId();
                }else{
                    $street_id = $find_street[0]->getId();
                }

            }
        }

        if(!empty($other_thing_request)){
            $thing = new Thing();
            $thing->setNameThing($other_thing_request);
            $thing->setBaseThing(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($thing);
            $em->flush();
            $thing_id = $thing->getId();
        }

        return $this->redirectToRoute('find');
    }

}
