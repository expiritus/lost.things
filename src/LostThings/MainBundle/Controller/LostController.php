<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 17.07.15
 * Time: 9:22
 */

namespace LostThings\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LostController extends Controller{

    public function indexAction(Request $request){
        $user = $this->getUser();
        if(!$user){
            return $this->redirect('/register');
        }
        return $this->render('LostThingsMainBundle:lost:index.html.twig');
    }
}