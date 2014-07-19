<?php

namespace VDM\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VdmBundle:Default:index.html.twig', array('name' => $name));
    }

    public function showAll(){

        $vdm = $em->getRepository('VdmBundle:Vdm')->findAll();
        return $this->render('VdmBundle:Default:index.html.twig', array('vdm' => $vdm));
    }

    public function showById($id){

        $vdm = $em->getRepository('VdmBundle:Vdm')->find($id);
        return $this->render('VdmBundle:Default:index.html.twig', array('vdm' => $vdm));
    }
}
