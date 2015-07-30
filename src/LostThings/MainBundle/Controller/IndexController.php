<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 17.07.15
 * Time: 9:17
 */

namespace LostThings\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller{

    public function indexAction()
    {
//        $securityContext = $this->container->get('security.context');
//        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')){
//            return $this->redirectToRoute('personal_area');
//        }
        return $this->render('LostThingsMainBundle:index:index.html.twig');
    }
}