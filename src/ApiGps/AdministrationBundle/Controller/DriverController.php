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
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->findAll();
        //dump($restresult);die();
        if ($results === null) {
            return new View("there are no drivers exist", Response::HTTP_NOT_FOUND);
        }

        foreach ($results as $result) {
            if (!empty ($result->getVehicle())) {

            $drivers[] = [
                'firstname' => $result->getFirstname(),
                'lastname' => $result->getLastname(),
                'tel' => $result->getTel(),
                'idvehicle' => $result->getVehicle()->getId(),
                'reg_number' => $result->getVehicle()->getRegNumber(),

            ];
            }
            else{
                $drivers[] = [
                    'firstname' => $result->getFirstname(),
                    'lastname' => $result->getLastname(),
                    'tel' => $result->getTel(),
                    'vehicle' => "aucune voiture associée à ce chauffeur",

                ];

            }
        }
        return $drivers;
    }

    ///////////////////////////////////////
    /////   Get drivers By Company    /////
    ///////////////////////////////////////

    /**
     * @Rest\Get("/driver/{id}/")
     * @param Request $request
     * @return array|View
     */
    public function getDriversByCompanyAction(Request $request)
    {
        $id = $request->get('id');
        //$drivers = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->findAll();
        //dump($drivers);die();

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')
            ->findBy(array('company' => $user->getCompany()));

        if ($results === null) {
            return new View("there are no drivers exist", Response::HTTP_NOT_FOUND);
        }

        foreach ($results as $result) {
            $mydrivers[] = [
                'firstname' => $result->getFirstname(),
                'lastname' => $result->getLastname(),
                'tel'=> $result->getTel(),
                'idvehicle'=> $result->getVehicle()->getId(),
                'reg_number'=> $result->getVehicle()->getRegNumber(),

            ];
        }
        return $mydrivers;

    }

    ///////////////////////////////////////
    /////     Add driver SuperAdmin   /////
    ///////////////////////////////////////

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
        $idcompany = $request->get('idcompany');
        if($idvehicle != null) {
            $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        }else{
            $vehicle=null;
        }

            $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);

        //var_dump($boitier);die();
        if(empty($firstname)|| empty($lastname) || empty($tel) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data -> setFirstname($firstname);
        $data -> setLastname($lastname);
        $data->setTel($tel);
        if(!empty($vehicle))
        $data->setVehicle($vehicle);
        $data->setCompany($company);

        //dump($data);die();

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("driver added Successfully", Response::HTTP_OK);


    }

    //////////////////////////////////////////
    /////     Add driver OperatorAdmin   /////
    //////////////////////////////////////////

    /**
     * @Rest\Post("/driver/{id}")
     * @param Request $request
     * @return string
     */
    public function postVehicleOperatorAction(Request $request)
    {

        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        $company = $user->getCompany();




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
        $data->setCompany($company);

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
