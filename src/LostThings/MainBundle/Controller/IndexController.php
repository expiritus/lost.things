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
        return $this->render('LostThingsMainBundle:index:index.html.twig');
    }
}