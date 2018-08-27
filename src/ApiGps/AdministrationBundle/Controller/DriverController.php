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

    /////////////////////////////
    /////  Get all drivers  /////
    /////////////////////////////

    /**
     * @Rest\Get("/driver")
     */
    public function getDriversAction()
    {
        $restresult = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->findAll();
        //dump($restresult);die();
        if ($restresult === null) {
            return new View("there are no drivers exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    ///////////////////////////////////////
    /////   Get drivers By Company    /////
    ///////////////////////////////////////

    /**
     * @Rest\Get("/driver/{id}")
     */
    public function getDriversByCompanyAction(Request $request)
    {
        $idcompany = $request->get('id');
        $drivers = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->findAll();



        $mydrivers = array();

        foreach ( $drivers as $driver){

            $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);


            if (!empty($driver->getVehicle())){
            if ($driver->getVehicle()->getCompany() == $company ){

                array_push($mydrivers,$driver);
            }
            }
        }



        if ($drivers === null) {
            return new View("there are no drivers exist", Response::HTTP_NOT_FOUND);
        }
        return $mydrivers;

    }

    /////////////////////////////
    /////     Add driver    /////
    /////////////////////////////

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

        //dump($data);die();

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("driver added Successfully", Response::HTTP_OK);

    }

    /////////////////////////////
    /////   update driver   /////
    /////////////////////////////

    /**
     * @Rest\Put("/driver/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updatedriverAction($id,Request $request)
    {
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $tel = $request->get('tel');
        $idvehicle = $request->get('idvehicle');
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $driver = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->find($id);

        if (empty($driver)) {
            return new View("Vehicle not found", Response::HTTP_NOT_ACCEPTABLE);
        }

        $driver->setFirstname($firstname);
        $driver->setLastname($lastname);
        $driver->setTel($tel);
        $driver->setVehicle($vehicle);
        $sn->flush();
        return new View("Vehicle Updated Successfully", Response::HTTP_OK);
    }


    ///////////////////////////////////////
    /////       Get driver By Id      /////
    ///////////////////////////////////////


    /**
     * @Rest\Get("/driver/{id}")
     */
    public function GetDriverByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('ApiGpsAdministrationBundle:Driver')->find($id);
        if ($singleresult === null) {
            return new View("driver not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

}
