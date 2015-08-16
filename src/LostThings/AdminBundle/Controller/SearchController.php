<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 16.08.15
 * Time: 14:14
 */

namespace LostThings\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
//    public function indexAction(){
//        $request = Request::createFromGlobals();
//        $uri = $request->getPathInfo();
//        $entity = strpos($uri, 'admin/');
//        $entity = substr($uri, $entity+6, -1);
//        $first = substr(strtolower($entity), 0, 1);
//        $last = substr(strtolower($entity), 1);
//        $search_entity = $first.$last;
//        if($request->query->get('search')){
//
//        }
//        return $this->render('LostThingsAdminBundle:helpers:search_form.html.twig', array(
//            'entity' => $search_entity
//        ));
//    }

    public function searchAction(){
//        $request = Request::createFromGlobals();
//        if($request->query->get('search')){
//            die();
//            $search = htmlspecialchars($request->query->get('search'));
//            $uri = $request->getPathInfo();
//            $entity = strpos($uri, 'admin/');
//            $entity = substr($uri, $entity+6, -1);
//            $first = substr(strtolower($entity), 0, 1);
//            $last = substr(strtolower($entity), 1);
//            $search_entity = $first.$last;
////        $entity = $this->getDoctrine()->getRepository("LostThingsAdminBundle:$search_entity")->search($search);
//        }
//
//        $uri = $request->getPathInfo();
//        $entity = strpos($uri, 'admin/');
//        $entity = substr($uri, $entity+6, -1);
//        $first = substr(strtolower($entity), 0, 1);
//        $last = substr(strtolower($entity), 1);
//        $search_entity = $first.$last;
////        $entity = $this->getDoctrine()->getRepository("LostThingsAdminBundle:$search_entity")->search($search);
//        return $this->render('LostThingsAdminBundle:helpers:search_form.html.twig');
    }

}