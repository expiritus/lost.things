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
    public function resultsSearchFindAction($id){
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAll();
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->find($id);
        $ids = array();
        for($l=0; $l<count($lost_things); $l++){
            if
            (
                (
                    $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                and $lost_things[$l]->getCityId() == $find_things->getCityId()
                and $lost_things[$l]->getAreaId() == $find_things->getAreaId()
                and $lost_things[$l]->getStreetId() == $find_things->getStreetId()
                and $lost_things[$l]->getThingId() == $find_things->getThingId()
                )
            or
                (
                    $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId() == $find_things->getCityId()
                    and $lost_things[$l]->getCityId() == $find_things->getAreaId()
                    and $lost_things[$l]->getThingId() == $find_things->getThingId()
                )
            or
                (
                    $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId() == $find_things->getCityId()
                    and $lost_things[$l]->getCityId() == $find_things->getStreetId()
                    and $lost_things[$l]->getThingId() == $find_things->getThingId()
                )
            or
                (
                    $lost_things[$l]->getCountryId() == $find_things->getCountryId()
                    and $lost_things[$l]->getCityId() == $find_things->getCityId()
                    and $lost_things[$l]->getThingId() == $find_things->getThingId()
                )
            )
            {
                $ids[] = $lost_things[$l]->getId();
            }
        }
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAllLostThings($ids);

        return $this->render('LostThingsMainBundle:search:results.html.twig', array(
            'lost_things' => $lost_things,
        ));
    }


    public function resultsSearchLostAction($id){
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->find($id);
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAll();
        $ids = array();
        for($f=0; $f<count($find_things); $f++){
            if
            (
                (
                    $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId() == $lost_things->getCityId()
                    and $find_things[$f]->getAreaId() == $lost_things->getAreaId()
                    and $find_things[$f]->getStreetId() == $lost_things->getStreetId()
                    and $find_things[$f]->getThingId() == $lost_things->getThingId()
                )

                or

                (
                    $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId() == $lost_things->getCityId()
                    and $find_things[$f]->getCityId() == $lost_things->getAreaId()
                    and $find_things[$f]->getThingId() == $lost_things->getThingId()
                )

                or

                (
                    $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId() == $lost_things->getCityId()
                    and $find_things[$f]->getCityId() == $lost_things->getStreetId()
                    and $find_things[$f]->getThingId() == $lost_things->getThingId()
                )

                or

                (
                    $find_things[$f]->getCountryId() == $lost_things->getCountryId()
                    and $find_things[$f]->getCityId() == $lost_things->getCityId()
                    and $find_things[$f]->getThingId() == $lost_things->getThingId()
                )
            )
            {
                $ids[] = $find_things[$f]->getId();
            }
        }
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findAllFindThings($ids);

        return $this->render('LostThingsMainBundle:search:results.html.twig', array(
            'find_things' => $find_things,
        ));
    }

}