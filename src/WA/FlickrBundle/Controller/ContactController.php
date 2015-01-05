<?php

namespace WA\FlickrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction()
    {
        //return $this->render('WAFlickrBundle:Contact:index.html.twig');
        $myFormContact=$this->create_contact_form();
        return $this->render('WAFlickrBundle:Contact:index.html.twig',
                                array("myFormContact"=>$myFormContact->createView()));
        //return $this->renderView( $page);
       // return $this->renderView(create_contact_form());

       /* if($this->get('request')->getMethod()=="POST")
        {
            je traite mon formulaire
            pas top, mieux vaut gérer via les routes
        }*/
    }
    public function saveAction(Request $request)
    {


        $myForm=$this->create_contact_form();
        $myForm->handleRequest($request);
        if ($myForm->isValid())
        {
            $formfields=$request->get('form');
            $message=\Swift_Message::newInstance()
                ->setSubject("formulaire de contact")
                ->setFrom($formfields['email'])
                ->setTo('ouldzein.saadna@gmail.com')
                ->setBody($formfields['message']);

            $this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('notice','votre mesage a été envoyé');
            //send mail
            $url=$this->generateUrl('wa_flickr_contact_index');
            return $this->redirect($url);
        }
        else
        {
            $this->get('session')->getFlashBag()->add('error','error validation');
            $url=$this->generateUrl('wa_flickr_contact_index');
            return $this->redirect($url);
        }

        /*$error = null;
        return $this->render('WAFlickrBundle:Contact:index.html.twig',
            array("myFormContact"=>$myForm->createView(),"error"=>"error validation"));*/

    }
    private function create_contact_form()
    {
         $formBuilder=$this->createFormBuilder();
         $formBuilder->add('firstname','text');
         $formBuilder->add('lastname','text');
         $formBuilder->add('email','email');
        // $formBuilder->add('message','text');
        $formBuilder->add('message', 'textarea', array('attr' => array('rows' => '5','cols' => '20')) );
         $formBuilder->add('send','submit');

        return $formBuilder->getForm();
    }
}
