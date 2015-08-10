<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 17.07.15
 * Time: 9:17
 */

namespace LostThings\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller{

    public function indexAction()
    {
        return $this->render('LostThingsMainBundle:index:index.html.twig');
    }

    public function aboutAction(){
        return $this->render('LostThingsMainBundle:index:about.html.twig');
    }

    public function contactAction(){
        return $this->render('LostThingsMainBundle:index:contact.html.twig');
    }

    public function testAction(){
        $lang = 0; // russian
        $headerOptions = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "Cookie: remixlang=$lang\r\n"
            )
        );
        $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
        $streamContext = stream_context_create($headerOptions);
        $json = file_get_contents($methodUrl, false, $streamContext);
        $arr = json_decode($json, true);
        echo 'Total countries count: ' . $arr['response']['count'] . ' loaded: ' . count($arr['response']['items']);
        print_r($arr['response']['items']);
    }
}