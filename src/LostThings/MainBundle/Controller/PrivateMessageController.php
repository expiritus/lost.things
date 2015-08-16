<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 02.08.15
 * Time: 11:39
 */

namespace LostThings\MainBundle\Controller;


use LostThings\AdminBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PrivateMessageController extends Controller
{

    public function messageAction(Request $request){
        $message = htmlspecialchars($request->request->get('message'));
        $message_id = htmlspecialchars($request->request->get('status_message'));
        $referer = $request->headers->get('referer');
        if($referer == 'http://'.$_SERVER['SERVER_NAME']."/personal-area/"){
            $refresh_status = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->find($message_id);

            $em = $this->getDoctrine()->getManager();
            $refresh_status->setStatus(1);
            $em->flush();
        }
        $whom = $request->request->get('whom');
        $send_user = $this->getUser();
        $received_user = $this->getDoctrine()->getRepository('LostThingsAdminBundle:User')->findOneBy(array('username' => $whom));
        $received_user->getId();

        $private_message = new Message();
        $private_message->setCurrentUsername($send_user);
        $private_message->setUsername($send_user);
        $private_message->setReceivedUsername($received_user);
        $private_message->setMessage($message);
        $private_message->setStatus(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($private_message);
        $em->flush();

        $referer = $request->headers->get('referer');
        $server_name = $_SERVER['SERVER_NAME'];
        $slash = strrpos($referer, '/');
        $id = substr($referer, $slash+1);
        if($referer == 'http://'.$server_name.'/find/search/'.$id or $referer == 'http://'.$server_name.'/lost/search/'.$id){
            return $this->redirect('/personal-area/');
        }

        return new RedirectResponse($referer);
    }



//    public function allSendCorrespondenceAction(){
//        $user = $this->getUser()->getId();
//        $all_send_correspondence = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findSend($user);
//        return $this->render('LostThingsMainBundle:private-message:all-correspondence.html.twig', array(
//            'all_send_correspondence' => $all_send_correspondence,
//        ));
//    }
//
//
//    public function allReceivedCorrespondenceAction(){
//        $user = $this->getUser()->getId();
//        $all_received_correspondence = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findReceived($user);
//        return $this->render('LostThingsMainBundle:private-message:all-correspondence.html.twig', array(
//            'all_received_correspondence' => $all_received_correspondence,
//        ));
//    }

    public function allCorrespondenceAction(){
        $user = $this->getUser()->getId();
        $all_send_correspondence = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findSend($user);
        $all_received_correspondence = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findReceived($user);
        return $this->render('LostThingsMainBundle:private-message:all-correspondence.html.twig', array(
            'all_received_correspondence' => $all_received_correspondence,
            'all_send_correspondence' => $all_send_correspondence,
        ));
    }


    public function correspondenceAction($received_user_id){
        return $this->render('LostThingsMainBundle:private-message:correspondence.html.twig', array(
            'received_user_id' => $received_user_id,
        ));
    }

    public function allMessagesAction(){
        $uri = $_SERVER['REQUEST_URI'];
        $slash = strrpos($uri, '/');
        $received_user_id = substr($uri, $slash+1);
        $send_user_id = $this->getUser();
        $all_messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findMessages($received_user_id, $send_user_id);
        $update_status_message = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->updateStatus($send_user_id->getId());
        return $this->render('LostThingsMainBundle:private-message:all-messages.html.twig', array(
            'all_messages' => $all_messages,
        ));
    }

    public function refreshCorrespondenceAction(Request $request, $received_user_id){
        $send_user_id = $this->getUser();
        if($request->request->get('message')){
            $message = htmlspecialchars($request->request->get('message'));
            $received_user = $this->getDoctrine()->getRepository('LostThingsAdminBundle:User')->find($received_user_id);
            $received_user->getId();
            $correspondence = new Message();
            $correspondence->setCurrentUsername($send_user_id);
            $correspondence->setUsername($send_user_id);
            $correspondence->setReceivedUsername($received_user);
            $correspondence->setMessage($message);
            $correspondence->setStatus(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($correspondence);
            $em->flush();
        }
        $all_messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findMessages($received_user_id, $send_user_id);
        $update_status_message = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->updateStatus($send_user_id->getId());
        return $this->render('LostThingsMainBundle:private-message:all-messages.html.twig', array(
            'all_messages' => $all_messages,
        ));
    }
//
//    public function saveCorrespondenceAction(Request $request){
//        $send_user_id = $this->getUser();
//        $referer = $request->headers->get('referer');
//        $slash = strrpos($referer, '/');
//        $received_user_id = substr($referer, $slash+1);
//        if($request->getMethod() == 'POST'){
//            $message = htmlspecialchars($request->request->get('message'));
//            $received_user = $this->getDoctrine()->getRepository('LostThingsAdminBundle:User')->find($received_user_id);
//            $received_user->getId();
//            $correspondence = new Message();
//            $correspondence->setCurrentUsername($send_user_id);
//            $correspondence->setUsername($send_user_id);
//            $correspondence->setReceivedUsername($received_user);
//            $correspondence->setMessage($message);
//            $correspondence->setStatus(0);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($correspondence);
//            $em->flush();
//            $referer = $request->headers->get('referer');
//            return new RedirectResponse($referer);
//        }
//    }

}