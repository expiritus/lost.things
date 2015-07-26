<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 26.07.15
 * Time: 10:01
 */

namespace LostThings\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PersonalAreaController extends Controller
{
    public function indexAction(){
        $user_id = $this->getUser()->getId();
        $all_user_finds = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findBy(array('userId' => $user_id));
        $all_user_losts = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findBy(array('userId' => $user_id));
        return $this->render('LostThingsMainBundle:personal-area:index.html.twig', array(
            'all_user_finds' => $all_user_finds,
            'all_user_losts' => $all_user_losts,
        ));
    }
}