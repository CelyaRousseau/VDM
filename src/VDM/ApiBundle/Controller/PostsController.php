<?php

namespace VDM\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\View\View,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class PostsController extends FOSRestController
{

    public function getPostsAction(){

        $em   = $this->getDoctrine()->getManager();
        $data = $em->getRepository('ApiBundle:Vdm')->findAll();

        // $posts = array();

        // foreach($data as $entry)
        // {
        //   $post_serialized = json_decode($entry,true);
        //   array_push($posts, $post_serialized);
        // }

        // $view = $this->view($data, 200)
                     // ->setFormat('jsonp');

        // return $this->handleView($view);

        return $data;
        
    }

    public function getPostAction($id){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('ApiBundle:Vdm')->find($id);
        
    }
}
