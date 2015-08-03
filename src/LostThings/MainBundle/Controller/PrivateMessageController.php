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
        $private_message->setUsername($send_user);
        $private_message->setReceivedUsername($received_user);
        $private_message->setMessage($message);
        $private_message->setStatus(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($private_message);
        $em->flush();

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    private function getUrl() {
        $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        return $url;
    }


    public function allCorrespondenceAction(){
        $user = $this->getUser()->getId();
        $all_correspondence = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findGroupBy($user);
        return $this->render('LostThingsMainBundle:private-message:all-correspondence.html.twig', array(
            'all_correspondence' => $all_correspondence,
        ));
    }


    public function correspondenceAction($received_user_id){
        $send_user_id = $this->getUser()->getId();
        $all_messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findMessages($received_user_id, $send_user_id);
        return $this->render('LostThingsMainBundle:private-message:correspondence.html.twig', array(
            'all_messages' => $all_messages,
        ));
    }

}