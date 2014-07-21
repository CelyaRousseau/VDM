<?php

namespace VDM\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\View\View,
    FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;


class PostsController extends FOSRestController
{


 
    /**
     * @QueryParam(name="from", description=" date from vdm", nullable=true)
     * @QueryParam(name="to", description="date to vdm", nullable=true)
     * @QueryParam(name="author", description="author's name", nullable=true)
     */
    public function getPostsAction(ParamFetcherInterface $paramFetcher){

        $author = $paramFetcher->get('author');
        $from   = $paramFetcher->get('from');
        $to     = $paramFetcher->get('to');

        $params = array('author' => $author , 'from' =>$from, 'to' => $to );

        $em   = $this->getDoctrine()->getManager();
        $data = $em->getRepository('ApiBundle:Vdm')->findVdmByParameters($params);

        return $data;
    }

    public function getPostAction($id){
        $em = $this->getDoctrine()->getManager();


        return $em->getRepository('ApiBundle:Vdm')->find($id);

        
    }

}
