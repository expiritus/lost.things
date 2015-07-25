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
    public function resultsSearchFindAction(Request $request, $id){
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAll();
        $find_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->find($id);
        $ids = array();
        for($l=0; $l<count($lost_things); $l++){
            if($lost_things[$l]->getCountryId() == $find_things->getCountryId()
                and $lost_things[$l]->getCityId() == $find_things->getCityId()
                and $lost_things[$l]->getAreaId() == $find_things->getAreaId()
                and $lost_things[$l]->getStreetId() == $find_things->getStreetId()
                and $lost_things[$l]->getThingId() == $find_things->getThingId()
            ){
                $ids[] = $lost_things[$l]->getId();
            }
        }
        $lost_things = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findAllLostThings($ids);

        return $this->render('LostThingsMainBundle:search:results.html.twig', array(
            'lost_things' => $lost_things,
        ));
    }

}