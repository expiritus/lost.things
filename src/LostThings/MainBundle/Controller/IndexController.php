<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 17.07.15
 * Time: 9:17
 */

namespace LostThings\MainBundle\Controller;

use LostThings\AdminBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller{

    public function indexAction()
    {
        return $this->render('LostThingsMainBundle:index:index.html.twig');
    }

    public function aboutAction(){
        return $this->render('LostThingsMainBundle:index:about.html.twig');
    }

    public function contactAction(Request $request){
        if($request->isXmlHttpRequest()) {
            $name = htmlspecialchars($request->request->get('contact_name'));
            $email = htmlspecialchars($request->request->get('contact_email'));
            $message = htmlspecialchars($request->request->get('contact_message'));
            $valid_data = array();

            if(!empty($name)){
                $valid_data['name'] = true;
            }else{
                $valid_data['name'] = false;
            }

            $validator = $this->container->get('validator');
            $constraints = array(
                new \Symfony\Component\Validator\Constraints\Email(),
                new \Symfony\Component\Validator\Constraints\NotBlank()
            );

            $error = $validator->validateValue($email, $constraints);
            if(count($error) > 0){
                $valid_data['email'] = false;
            }else{
                $valid_data['email'] = true;
            }

            if(!empty($message)){
                $valid_data['message'] = true;
            }else{
                $valid_data['message'] = false;
            }

            if($valid_data['name'] == true and $valid_data['email'] == true and $valid_data['message'] == true){
                $contact = new Contact();
                $em = $this->getDoctrine()->getEntityManager();
                $contact->setUserName($name);
                $contact->setEmail($email);
                $contact->setMessage($message);
                $em->persist($contact);
                $em->flush();
                if ($contact) {
                    $msg = \Swift_Message::newInstance()
                        ->setSubject('Contact')
                        ->setFrom('antras2007@gmail.com')
                        ->setTo('antras6762632@yandex.ru')
                        ->setBody(
                            $this->renderView(
                            // app/Resources/views/Emails/registration.html.twig
                                'Emails/contact_email.html.twig',
                                array(
                                    'name' => $name,
                                    'email' => $email,
                                    'message' => $message
                                )
                            ),
                            'text/html'
                        )
                    ;

                    $this->get('mailer')->send($msg);

                    $valid_data['flash'] = 'Сообщение отправлено';
                    $response = new Response(json_encode($valid_data));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                }else{
                    $valid_data['flash'] = 'Не удалось отправить сообщение';
                }
            }else{
                $response = new Response(json_encode($valid_data));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        return $this->render('LostThingsMainBundle:index:contact.html.twig');
    }

//    public function testAction(){
//        $lang = 0; // russian
//        $headerOptions = array(
//            'http' => array(
//                'method' => "GET",
//                'header' => "Accept-language: en\r\n" .
//                    "Cookie: remixlang=$lang\r\n"
//            )
//        );
//        $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
//        $streamContext = stream_context_create($headerOptions);
//        $json = file_get_contents($methodUrl, false, $streamContext);
//        $arr = json_decode($json, true);
//        echo 'Total countries count: ' . $arr['response']['count'] . ' loaded: ' . count($arr['response']['items']);
//        print_r($arr['response']['items']);
//    }
}