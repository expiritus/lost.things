<?php

namespace LostThings\AdminBundle\Controller;

use LostThings\AdminBundle\Entity\Lost;
use LostThings\AdminBundle\Form\LostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LostThingsAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
