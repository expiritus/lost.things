<?php

namespace LostThings\AdminBundle\Controller;

use LostThings\AdminBundle\Entity\Lost;
use LostThings\AdminBundle\Form\LostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('LostThingsAdminBundle:index:index.html.twig');
    }
}
