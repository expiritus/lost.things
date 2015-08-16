<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 26.07.15
 * Time: 10:01
 */

namespace LostThings\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonalAreaController extends Controller
{
    public function indexAction(Request $request){
        $user = $this->getUser();
        if ($user) {
            $user_id = $this->getUser()->getId();
            $all_user_finds = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findBy(array('userId' => $user_id));
            $all_user_losts = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findBy(array('userId' => $user_id));
            $messages = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Message')->dontReadMessage($user_id);
            if(count($messages) > 0){
                $em = $this->getDoctrine()->getManager();
                for($i=0; $i<count($messages); $i++){
                    $messages[$i]->setStatus(1);
                }
                $em->flush();
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
            $filename = $del_thing->getFileName();
            $em->remove($del_thing);
            $em->flush();
            if($filename != null){
                $file = $this->get('kernel')->getRootDir().'/../web/files/'.$filename;
                unlink($file);
            }
            die(true);
        }
        die(false);
    }

    public function editLostAction(Request $request, $id){
        if($request->request->get('save_edit_lost')){
            $update_description = htmlspecialchars($request->request->get('update_description'));
            $update_lost = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->find($id);
            $update_lost->setDescription($update_description);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('LostThingsMainBundle:personal-area:description.html.twig', array(
                'update_description' => $update_lost,
            ));
        }else{
            $edit_thing = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Lost')->findOneBy(array('id' => $id));
            return $this->render('LostThingsMainBundle:personal-area:edit.html.twig', array(
                'id' => $id,
                'edit_thing' => $edit_thing,
            ));
        }
    }

    public function editFindAction(Request $request, $id){
        if($request->request->get('save_edit_find')){
            $update_description = htmlspecialchars($request->request->get('update_description'));
            $update_find = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->find($id);
            $update_find->setDescription($update_description);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('LostThingsMainBundle:personal-area:description.html.twig', array(
                'update_description' => $update_find,
            ));
        }else{
            $edit_thing = $this->getDoctrine()->getRepository('LostThingsAdminBundle:Find')->findOneBy(array('id' => $id));
            return $this->render('LostThingsMainBundle:personal-area:edit.html.twig', array(
                'id' => $id,
                'edit_thing' => $edit_thing,
            ));
        }
    }


    public function deleteFindAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $del_thing = $em->getRepository('LostThingsAdminBundle:Find')->findOneBy(array('id' => $id));
        if(count($del_thing) > 0){
            $filename = $del_thing->getFileName();
            $em->remove($del_thing);
            $em->flush();
            if($filename != null){
                $file = $this->get('kernel')->getRootDir().'/../web/files/'.$filename;
                unlink($file);
            }
            die(true);
        }
        die(false);
    }


}