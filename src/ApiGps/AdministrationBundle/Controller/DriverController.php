<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Driver;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class DriverController extends FOSRestController
{


    /**
     * @Rest\Get("/driver")
     */
    public function getDriversAction()
    {
        $restresult = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->findAll();        if ($restresult === null) {
            return new View("there are no drivers exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Post("/driver")
     * @param Request $request
     * @return string
     */
    public function postVehicleAction(Request $request)
    {
        $data = new Driver();
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $tel = $request->get('tel');
        $idvehicle = $request->get('idvehicle');
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);

        //var_dump($boitier);die();
        if(empty($firstname)|| empty($lastname) || empty($tel) || empty($idvehicle))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data -> setFirstname($firstname);
        $data -> setLastname($lastname);
        $data->setTel($tel);
        $data->setVehicle($vehicle);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("driver added Successfully", Response::HTTP_OK);    }

}
