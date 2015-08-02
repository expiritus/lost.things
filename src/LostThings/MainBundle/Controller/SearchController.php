<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 25.07.15
 * Time: 11:06
 */

namespace LostThings\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    private $ids_lost = array();
    private $ids_find = array();

    public function resultsSearchFindAction($id){
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAll();
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->find($id);
        for($l=0; $l<count($lost_things); $l++) {
            if
            (
                    $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                and $lost_things[$l]->getAreaId()    == $find_things->getAreaId()
                and $lost_things[$l]->getStreetId()  == $find_things->getStreetId()
                and $lost_things[$l]->getThingId()   == $find_things->getThingId()
            )
            {
                $this->ids_find[] = $lost_things[$l]->getId();
                $request = Request::createFromGlobals();
                if($request->getMethod() == 'GET'){
                    $email_to = $lost_things[$l]->getUsername()->getEmail();
                    $name = $lost_things[$l]->getUsername();
                    if(count($this->ids_find) > 0){
                        $message = \Swift_Message::newInstance()
                            ->setSubject('Hello Email')
                            ->setFrom('antras2007@gmail.com')
                            ->setTo($email_to)
                            ->setBody(
                                $this->renderView(
                                // app/Resources/views/Emails/registration.html.twig
                                    'Emails/matches.html.twig',
                                    array('name' => $name)
                                ),
                                'text/html'
                            )
                        ;
                        $this->get('mailer')->send($message);
                    }
                }
            }
        }

        if(count($this->ids_find) > 0){
            $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAllLostThings($this->ids_find);
            return $this->render('LostThingsMainBundle:search:results.html.twig', array(
                'lost_things' => $lost_things,
            ));
        }

        for($l=0; $l<count($lost_things); $l++){
            if(
                (
                        $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                    and $lost_things[$l]->getCityId()    == $find_things->getAreaId()
                    and $lost_things[$l]->getThingId()   == $find_things->getThingId()
                )
            or
                (
                        $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                    and $lost_things[$l]->getCityId()    == $find_things->getStreetId()
                    and $lost_things[$l]->getThingId()   == $find_things->getThingId()
                )
            or
                (
                        $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                    and $lost_things[$l]->getThingId()   == $find_things->getThingId()
                )
            )
            {
                $this->ids_find[] = $lost_things[$l]->getId();
                $request = Request::createFromGlobals();
                if($request->getMethod() == 'GET'){
                    $email_to = $lost_things[$l]->getUsername()->getEmail();
                    $name = $lost_things[$l]->getUsername();
                    if(count($this->ids_find) > 0){
                        $message = \Swift_Message::newInstance()
                            ->setSubject('Hello Email')
                            ->setFrom('antras2007@gmail.com')
                            ->setTo($email_to)
                            ->setBody(
                                $this->renderView(
                                // app/Resources/views/Emails/registration.html.twig
                                    'Emails/matches.html.twig',
                                    array('name' => $name)
                                ),
                                'text/html'
                            )
                        ;
                        $this->get('mailer')->send($message);
                    }
                }
            }
        }
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAllLostThings($this->ids_find);
        return $this->render('LostThingsMainBundle:search:results.html.twig', array(
            'lost_things' => $lost_things,
        ));
    }


    public function resultsSearchLostAction($id){
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->find($id);
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAll();
        for($f=0; $f<count($find_things); $f++) {
            if
            (
                $find_things[$f]->getCountryId()    == $lost_things->getCountryId()
                and $find_things[$f]->getCityId()   == $lost_things->getCityId()
                and $find_things[$f]->getAreaId()   == $lost_things->getAreaId()
                and $find_things[$f]->getStreetId() == $lost_things->getStreetId()
                and $find_things[$f]->getThingId()  == $lost_things->getThingId()
            )
            {
                $this->ids_lost[] = $find_things[$f]->getId();
                $request = Request::createFromGlobals();
                if($request->getMethod() == 'GET'){
                    $email_to = $find_things[$f]->getUsername()->getEmail();
                    $name = $find_things[$f]->getUsername();
                    if(count($this->ids_lost) > 0){
                        $message = \Swift_Message::newInstance()
                            ->setSubject('Matches things')
                            ->setFrom('antras2007@gmail.com')
                            ->setTo($email_to)
                            ->setBody(
                                $this->renderView(
                                    'Emails/matches.html.twig',
                                    array('name' => $name)
                                ),
                                'text/html'
                            )
                        ;
                        $this->get('mailer')->send($message);
                    }
                }
            }
        }

        if(count($this->ids_lost) > 0){
            $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAllFindThings($this->ids_lost);
            return $this->render('LostThingsMainBundle:search:results.html.twig', array(
                'find_things' => $find_things,
            ));
        }

        for($f=0; $f<count($find_things); $f++){
            if(
                (
                        $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId()    == $lost_things->getCityId()
                    and $find_things[$f]->getCityId()    == $lost_things->getAreaId()
                    and $find_things[$f]->getThingId()   == $lost_things->getThingId()
                )

                or

                (
                        $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId()    == $lost_things->getCityId()
                    and $find_things[$f]->getCityId()    == $lost_things->getStreetId()
                    and $find_things[$f]->getThingId()   == $lost_things->getThingId()
                )

                or

                (
                        $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId()    == $lost_things->getCityId()
                    and $find_things[$f]->getThingId()   == $lost_things->getThingId()
                )
            )
            {
                $this->ids_lost[] = $find_things[$f]->getId();
                $request = Request::createFromGlobals();
                if($request->getMethod() == 'GET'){
                    $email_to = $find_things[$f]->getUsername()->getEmail();
                    $name = $find_things[$f]->getUsername();
                    if(count($this->ids_lost) > 0){
                        $message = \Swift_Message::newInstance()
                            ->setSubject('Matches things')
                            ->setFrom('antras2007@gmail.com')
                            ->setTo($email_to)
                            ->setBody(
                                $this->renderView(
                                    'Emails/matches.html.twig',
                                    array('name' => $name)
                                ),
                                'text/html'
                            )
                        ;
                        $this->get('mailer')->send($message);
                    }
                }
            }
        }

        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAllFindThings($this->ids_lost);

        return $this->render('LostThingsMainBundle:search:results.html.twig', array(
            'find_things' => $find_things,
        ));
    }


    public function countLostMatchesAction($id){
        $this->resultsSearchLostAction($id);
        $count = count($this->ids_lost);
        $response = new Response(json_encode($count));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    public function countFindMatchesAction($id){
        $this->resultsSearchFindAction($id);
        $count = count($this->ids_find);
        $response = new Response(json_encode($count));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    public function personalAreaResultSearchLostAction($id){
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->find($id);
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAll();
        for($f=0; $f<count($find_things); $f++) {
            if
            (
                    $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                and $find_things[$f]->getCityId()    == $lost_things->getCityId()
                and $find_things[$f]->getAreaId()    == $lost_things->getAreaId()
                and $find_things[$f]->getStreetId()  == $lost_things->getStreetId()
                and $find_things[$f]->getThingId()   == $lost_things->getThingId()
            )
            {
                $this->ids_lost[] = $find_things[$f]->getId();
            }
        }

        if(count($this->ids_lost) > 0){
            $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAllFindThings($this->ids_lost);
            return $this->render('LostThingsMainBundle:search:results.html.twig', array(
                'find_things' => $find_things,
            ));
        }

        for($f=0; $f<count($find_things); $f++){
            if(

                (
                        $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId()    == $lost_things->getCityId()
                    and $find_things[$f]->getCityId()    == $lost_things->getAreaId()
                    and $find_things[$f]->getThingId()   == $lost_things->getThingId()
                )

                or

                (
                        $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId()    == $lost_things->getCityId()
                    and $find_things[$f]->getCityId()    == $lost_things->getStreetId()
                    and $find_things[$f]->getThingId()   == $lost_things->getThingId()
                )

                or

                (
                        $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId()    == $lost_things->getCityId()
                    and $find_things[$f]->getThingId()   == $lost_things->getThingId()
                )
            )
            {
                $this->ids_lost[] = $find_things[$f]->getId();
            }
        }
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAllFindThings($this->ids_lost);
        return $this->render('LostThingsMainBundle:search:results.html.twig', array(
            'find_things' => $find_things,
        ));
    }




    public function personalAreaResultSearchFindAction($id){
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAll();
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->find($id);
        for($l=0; $l<count($lost_things); $l++) {
            if
            (
                    $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                and $lost_things[$l]->getAreaId()    == $find_things->getAreaId()
                and $lost_things[$l]->getStreetId()  == $find_things->getStreetId()
                and $lost_things[$l]->getThingId()   == $find_things->getThingId()
            )
            {
                $this->ids_find[] = $lost_things[$l]->getId();
            }
        }

        if(count($this->ids_find) > 0){
            $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAllLostThings($this->ids_find);
            return $this->render('LostThingsMainBundle:search:results.html.twig', array(
                'lost_things' => $lost_things,
            ));
        }

        for($l=0; $l<count($lost_things); $l++){
            if(
                (
                        $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                    and $lost_things[$l]->getCityId()    == $find_things->getAreaId()
                    and $lost_things[$l]->getThingId()   == $find_things->getThingId()
                )
                or
                (
                        $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                    and $lost_things[$l]->getCityId()    == $find_things->getStreetId()
                    and $lost_things[$l]->getThingId()   == $find_things->getThingId()
                )
                or
                (
                        $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId()    == $find_things->getCityId()
                    and $lost_things[$l]->getThingId()   == $find_things->getThingId()
                )
            )
            {
                $this->ids_find[] = $lost_things[$l]->getId();
            }
        }
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAllLostThings($this->ids_find);
        return $this->render('LostThingsMainBundle:search:results.html.twig', array(
            'lost_things' => $lost_things,
        ));
    }

}