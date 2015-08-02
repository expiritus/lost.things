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

}