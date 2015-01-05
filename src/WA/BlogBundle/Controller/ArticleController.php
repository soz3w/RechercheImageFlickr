<?php

namespace WA\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function indexAction($id)
    {
       // return new Response("Hello world");

            // $url=$this->get('router')->generate('wa_flickr_helloword',array("name"=>"Bryan","age"=>"38"));
        //plus court
        $url=$this->generateUrl('wa_blog_article',array("id"=>$id));
        //$id+=1;
        //$this->render(..) aurait marcher aussi
        $content=$this->get('templating')->render('WABlogBundle:Article:articleContent.html.twig',
            array("id"=>$id,"url"=>$url));
        return new Response($content);
    }
}
