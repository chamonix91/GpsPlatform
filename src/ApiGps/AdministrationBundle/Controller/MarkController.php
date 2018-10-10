<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Mark;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class MarkController extends  FOSRestController
{

    /////////////////////////////
    /////   Get all marks   /////
    /////////////////////////////


    /**
     * @Rest\Get("/mark")
     */
    public function getMarkAction()
    {
        $marks = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Mark')->findAll();
        if ($marks === null) {
            return new View("there are no marks exist", Response::HTTP_NOT_FOUND);
        }
        return $marks;
    }


    //////////////////////////
    /////     Add mark   /////
    //////////////////////////

    /**
     * @Rest\Post("/mark/")
     * @param Request $request
     * @return View
     */
    public function postMarkAction(Request $request)
    {
        $data = new Mark();
        $name = $request->get('name');
        //$idVehicle = $request->get('idvehicle');
        //$Vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idVehicle);
        if(empty($name))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setName($name);
        //$data->setVehicle($Vehicle);
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        $result = new View("Mark Added Successfully", Response::HTTP_OK);
        return $result;
 }
}
