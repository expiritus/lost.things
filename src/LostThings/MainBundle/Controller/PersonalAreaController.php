<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 26.07.15
 * Time: 10:01
 */

namespace LostThings\MainBundle\Controller;


use LostThings\AdminBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PersonalAreaController extends Controller
{
    public function indexAction(Request $request){

        $referer = $request->headers->get('referer');
        $slash = strrpos($referer, '/');
        $id = substr($referer, $slash+1);
        $server_name = $_SERVER['SERVER_NAME'];
        if($referer == 'http://'.$server_name.'/personal-area/correspondence/'.$id){
            $status_message = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->findBy(array('sendUserId' => $id));
            $em = $this->getDoctrine()->getManager();
            for($i=0; $i<count($status_message); $i++){
                $status_message[$i]->setStatus(1);
            }
            $em->flush();
        }

        $user = $this->getUser();
        if ($user) {
            $user_id = $this->getUser()->getId();
            $all_user_finds = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findBy(array('userId' => $user_id));
            $all_user_losts = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findBy(array('userId' => $user_id));
            $messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->dontReadMessage($user_id);
            $em = $this->getDoctrine()->getManager();
            for($i=0; $i<count($messages); $i++){
                $messages[$i]->setStatus(1);
            }
            $em->flush();
            if(count($messages) > 0){
                return $this->render('LostThingsMainBundle:personal-area:index.html.twig', array(
                    'all_user_finds' => $all_user_finds,
                    'all_user_losts' => $all_user_losts,
                    'dont_read_messages' => $messages
                ));
            }
            return $this->render('LostThingsMainBundle:personal-area:index.html.twig', array(
                'all_user_finds' => $all_user_finds,
                'all_user_losts' => $all_user_losts,
            ));
        }
        return $this->redirect('/login');
    }


    public function deleteLostAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $del_thing = $em->getRepository('LostThingsAdminBundle:Lost')->findOneBy(array('id' => $id));
        if(count($del_thing) > 0){
            $em->remove($del_thing);
            $em->flush();
            die(true);
        }
        die(false);
    }


    public function deleteFindAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $del_thing = $em->getRepository('LostThingsAdminBundle:Find')->findOneBy(array('id' => $id));
        if(count($del_thing) > 0){
            $em->remove($del_thing);
            $em->flush();
            die(true);
        }
        die(false);
    }


}