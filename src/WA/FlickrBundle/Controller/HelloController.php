<?php

namespace WA\FlickrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{
    public function indexAction($name,$age)
    {
       // return new Response("Hello world");

            // $url=$this->get('router')->generate('wa_flickr_helloword',array("name"=>"Bryan","age"=>"38"));
        //plus court
        $url=$this->generateUrl('wa_flickr_helloword',array("name"=>"Bryan","age"=>"38"));

        //$this->render(..) aurait marcher aussi
        $content=$this->get('templating')->render('WAFlickrBundle:Hello:index.html.twig',
            array("name"=>$name,"age"=>$age,"url"=>$url));
        return new Response($content);
    }
}
