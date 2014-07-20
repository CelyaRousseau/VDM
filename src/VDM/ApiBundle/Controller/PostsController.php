<?php

namespace VDM\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostsController extends Controller
{

    public function getPostsAction(){

        $vdm = $em->getRepository('ApiBundle:Vdm')->findAll();
        return $this->render('ApiBundle:Default:index.html.twig', array('vdm' => $vdm));
    }

    public function getPostAction($id){

        $vdm = $em->getRepository('ApiBundle:Vdm')->find($id);
        return $this->render('ApiBundle:Default:index.html.twig', array('vdm' => $vdm));
    }
}
