<?php

namespace WA\FlickrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WA\FlickrBundle\Infrastructure\FlickrService;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function indexAction()
    {
        $mySearchForm=$this->create_search_form();
        return $this->render('WAFlickrBundle:Search:index.html.twig',
                                array("mySearchForm"=>$mySearchForm->createView()));

    }


    private function create_search_form()
    {
        $formBuilder=$this->createFormBuilder();
        $formBuilder->add('tags','text');
        $formBuilder->add('maximum','choice',['choices'=>[10=>10,20=>20,30=>30]]);
        $formBuilder->add('size','choice',['choices'=>['b'=>'big','z'=>'mid','m'=>'small']]);
        $formBuilder->add('send','submit');

        return $formBuilder->getForm();
    }

    public function getImageDescAction($id,$secret,Request $request)
    {
       // $refer=$request->getRequest()->headers->get('refer');
        $flickrservice = new FlickrService();
        $photo=$flickrservice->getPhotoInfos($id,$secret);
        $content=$this->get('templating')->render('WAFlickrBundle:Search:imageDesc.html.twig',
            array("photo"=>$photo));
        return new Response($content);
    }

    public function findOutAction(Request $request)
    {


        $myForm=$this->create_search_form();
        $myForm->handleRequest($request);
        if ($myForm->isValid())
        {
            $formfields=$request->get('form');

            $tags=$formfields['tags'];
            $maximum=$formfields['maximum'];
            $width=$formfields['taille'];

            $flickrservice = new FlickrService();
            $photos=$flickrservice->searchPhoto($tags,$width,$maximum);

            $this->get('session')->getFlashBag()->add('notice','');

           // $url=$this->generateUrl('wa_flickr_search_index');
           // return $this->redirect($url,array('photos' => $photos));

            return $this->render('WAFlickrBundle:Search:index.html.twig',
                array("mySearchForm"=>$myForm->createView(),"photos"=>$photos));
        }
        else
        {
            $this->get('session')->getFlashBag()->add('error','form validation error');
            $url=$this->generateUrl('wa_flickr_search_index');
            return $this->redirect($url);
        }


    }
    public function addToFavoriteAction($id,$secret,Request $request)
    {
        $flickrservice = new FlickrService();
        $photo=$flickrservice->getPhotoInfos($id,$secret);
        $session=$request->getSession();
        $photosFav=$session->get('photos');
       // dump($session->get('photos'));
       // die;
        if($photosFav)
            array_push($photosFav,$photo);
        else
        {
            $photosFav=array();
            array_push($photosFav,$photo);
        }


        $session->set('photos',$photosFav);
         $url=$this->generateUrl('wa_flickr_search_index');
         return $this->redirect($url);
    }
}
