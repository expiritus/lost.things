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
        if($request->isXmlHttpRequest()){
            $id_message = htmlspecialchars($request->request->get('id_message'));
            $update_status = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->find($id_message);
            $update_status->setStatus(1);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            die();
        }
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


    public function allCorrespondenceAction(){
        $user = $this->getUser()->getId();
        $all_send_correspondence = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findSend($user);
        $all_send = array();
        $all_received = array();
        for($i=0; $i<count($all_send_correspondence); $i++){
            $all_send[] = $all_send_correspondence[$i]->getReceivedUsername()->getUsername();
        }
        $all_received_correspondence = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findReceived($user);
        for($i=0; $i<count($all_received_correspondence); $i++){
            $all_received[] = $all_received_correspondence[$i]->getUsername()->getUsername();
        }

        $send_unique = array_unique($all_send);
        $received_unique = array_unique($all_received);
        $unique_user_correspondence = array_merge($send_unique, $received_unique);
        $unique_user_correspondence = array_unique($unique_user_correspondence);
        return $this->render('LostThingsMainBundle:private-message:all-correspondence.html.twig', array(
            'unique_user_correspondence' => $unique_user_correspondence,
        ));

//        return $this->render('LostThingsMainBundle:private-message:all-correspondence.html.twig');
    }


    public function correspondenceAction($received_user){
        return $this->render('LostThingsMainBundle:private-message:correspondence.html.twig', array(
            'received_user' => $received_user,
        ));
    }

    public function allMessagesAction(){
        $uri = $_SERVER['REQUEST_URI'];
        $slash = strrpos($uri, '/');
        $received_user = substr($uri, $slash+1);
        $send_user_id = $this->getUser();
        $all_messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findMessages($received_user, $send_user_id);
//        $all_messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findAll();
        $update_status_message = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->updateStatus($send_user_id->getId());
        return $this->render('LostThingsMainBundle:private-message:all-messages.html.twig', array(
            'all_messages' => $all_messages,
        ));
    }

    public function refreshCorrespondenceAction(Request $request, $received_user){
        $send_user_id = $this->getUser();
        if($request->request->get('message')){
            $message = htmlspecialchars($request->request->get('message'));
            $received = $this->getDoctrine()->getRepository('LostThingsAdminBundle:User')->findOneBy(array('username' => $received_user));
            $received->getId();
            $correspondence = new Message();
            $correspondence->setCurrentUsername($send_user_id);
            $correspondence->setUsername($send_user_id);
            $correspondence->setReceivedUsername($received);
            $correspondence->setMessage($message);
            $correspondence->setStatus(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($correspondence);
            $em->flush();
        }
        $all_messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findMessages($received_user, $send_user_id);
        $update_status_message = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->updateStatus($send_user_id->getId());
        return $this->render('LostThingsMainBundle:private-message:all-messages.html.twig', array(
            'all_messages' => $all_messages,
        ));
    }
}