<?php

namespace ApiGps\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class AlertController extends FOSRestController
{
    /////////////////////////////
    /////  Get all alert  /////
    /////////////////////////////

    /**
     * @Rest\Get("/alert")
     */
    public function getAlertsAction()
    {
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->findAll();
        //dump($restresult);die();
        if ($results === null) {
            return new View("there are no drivers exist", Response::HTTP_NOT_FOUND);
        }

        foreach ($results as $result) {

                $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                ];

        }
        return $drivers;
    }

    ///////////////////////////////////////
    /////   Get alert By Company    /////
    ///////////////////////////////////////

    /**
     * @Rest\Get("/alert/{id}/")
     * @param Request $request
     * @return array|View
     */
    public function getDriversByCompanyAction(Request $request)
    {
        $id = $request->get('id');
        //$drivers = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->findAll();
        //dump($drivers);die();

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')
            ->findBy(array('company' => $user->getCompany()));

        if ($results === null) {
            return new View("there are no drivers exist", Response::HTTP_NOT_FOUND);
        }

        /*foreach ($results as $result) {
            $mydrivers[] = [
                'firstname' => $result->getFirstname(),
                'lastname' => $result->getLastname(),
                'tel' => $result->getTel(),
                'idvehicle' => $result->getVehicle()->getId(),
                'reg_number' => $result->getVehicle()->getRegNumber(),

            ];

        }*/
        return $results;

    }

    ///////////////////////////////////////
    /////     Add driver SuperAdmin   /////
    ///////////////////////////////////////

    /**
     * @Rest\Post("/alert")
     * @param Request $request
     * @return string
     */
    public function postVehicleAction(Request $request)
    {
        $data = new Driver();
        /*
         *  $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                ];*/
        $libele = $request->get('libele');
        $type = $request->get('type');
        $description = $request->get('description');
        $valeur = $request->get('valeur');
        $idcompany = $request->get('idcompany');
        if($idcompany != null) {
            $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
            $data->setCompany($company);
        }else{
            $company=null;
        }


        //var_dump($boitier);die();
        if(empty($libele)|| empty($type) || empty($valeur) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibele($libele);
        $data ->setType($type);
        $data->setValeur($valeur);
        $data->setDescription($description);

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
     * @Rest\Post("/alert/{id}")
     * @param Request $request
     * @return string
     */
    public function postVehicleOperatorAction(Request $request)
    {

        $data = new Driver();
        /*
         *  $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                ];*/
        $libele = $request->get('libele');
        $type = $request->get('type');
        $description = $request->get('description');
        $valeur = $request->get('valeur');
        $idcompany = $request->get('id');

            $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);


        //var_dump($boitier);die();
        if(empty($libele)|| empty($type) || empty($valeur) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibele($libele);
        $data ->setType($type);
        $data->setValeur($valeur);
        $data->setDescription($description);
        $data->setDescription($description);
        $data->setCompany($company);
        //dump($data);die();

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("driver added Successfully", Response::HTTP_OK);


    }

    /////////////////////////////
    /////   update alert   /////
    /////////////////////////////

    /**
     * @Rest\Put("/alert/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updatedriverAction($id,Request $request)
    {
        $libele = $request->get('libele');
        $type = $request->get('type');
        $description = $request->get('description');
        $valeur = $request->get('valeur');
        $id = $request->get('id');

        $sn = $this->get('doctrine_mongodb')->getManager();
        $driver = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);

        if (empty($driver)) {
            return new View("Vehicle not found", Response::HTTP_NOT_ACCEPTABLE);
        }

       /* $driver->setFirstname($firstname);
        $driver->setLastname($lastname);
        $driver->setTel($tel);*/
        //$driver->setVehicle($vehicle);
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

    //////////////////////////////
    ////////  Bound  Driver  /////
    //////////////////////////////

    /**
     * @Rest\Put("/bonddriver/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function BondDriverAction($id,Request $request)
    {
        $a=new \DateTime('now');
        $b=$a->format('Y-m-d ');
        $bond_date = strtotime($b);
        $idVehicle = $request->get('idvehicle');
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idVehicle);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $driver = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->find($id);
        if (empty($driver)) {
            return new View("driver not found", Response::HTTP_NOT_FOUND);

        }

        $driver->setBondDate($bond_date);
        $driver->setVehicle($vehicle);
        $driver->setEndbondDate(null);
        $sn->merge($driver);
        $sn->flush();
        return new View("driver Updated Successfully", Response::HTTP_OK);


    }

    //////////////////////////////
    ////////  UnBond Driver //////
    //////////////////////////////

    /**
     * @Rest\Put("/unbonddriver/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function EndBondDriverAction($id,Request $request)
    {
        $a=new \DateTime('now');
        $b=$a->format('Y-m-d ');
        $bond_date = strtotime($b);
        $endbond_date = strtotime($b);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $driver = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->find($id);


        if (empty($driver)) {
            return new View("driver not found", Response::HTTP_NOT_FOUND);

        }


        $driver->setEndbondDate($endbond_date);
        $driver->setVehicle(null);
        $driver->setBondDate(null);
        $sn->merge($driver);
        $sn->flush();
        return new View("driver Updated Successfully", Response::HTTP_OK);


    }



}
