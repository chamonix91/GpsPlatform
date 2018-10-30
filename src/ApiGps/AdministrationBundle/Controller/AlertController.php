<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Alert;
use ApiGps\AdministrationBundle\Document\Driver;
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
    /////  Get all alerts   /////
    /////////////////////////////

    /**
     * @Rest\Get("/alert")
     */
    public function getAlertsAction()
    {
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->findAll();
        //dump($restresult);die();
        if ($results === null) {
            return new View("there are no alert exist", Response::HTTP_NOT_FOUND);
        }

        foreach ($results as $result) {

                $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibelle(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                    'company' => $result->getCompany(),
                    'active' => $result->getActive(),
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
    public function getAlertsByCompanyAction(Request $request)
    {
        $id = $request->get('id');
        //$drivers = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Driver')->findAll();
        //dump($drivers);die();

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')
            ->findBy(array('company' => $user->getCompany()));

        if ($results === null) {
            return new View("there are no alerts exist", Response::HTTP_NOT_FOUND);
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
    /////     Add Alert SuperAdmin   /////
    ///////////////////////////////////////

    /**
     * @Rest\Post("/alert")
     * @param Request $request
     * @return string
     */
    public function postAlertAction(Request $request)
    {
        $data = new Alert();
        /*
         *  $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                ];*/
        $libelle = $request->get('libelle');
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
        if(empty($libelle)|| empty($type) || empty($valeur) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibelle($libelle);
        $data ->setActive(true);
        $data ->setType($type);
        $data->setValeur($valeur);
        $data->setDescription($description);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Alert added Successfully", Response::HTTP_OK);


    }

    //////////////////////////////////////////
    /////     Add driver OperatorAdmin   /////
    //////////////////////////////////////////

    /**
     * @Rest\Post("/alert/{id}")
     * @param Request $request
     * @return string
     */
    public function postAlertOperatorAction(Request $request)
    {

        $data = new Alert();

        $libelle = $request->get('libelle');
        $type = $request->get('type');
        $description = $request->get('description');
        $valeur = $request->get('valeur');
        $idcompany = $request->get('id');

            $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);


        if(empty($libelle)|| empty($type) || empty($valeur) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibelle($libelle);
        $data ->setType($type);
        $data->setValeur($valeur);
        $data->setActive(true);
        $data->setDescription($description);
        $data->setCompany($company);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Alert added Successfully", Response::HTTP_OK);


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
    public function updateAlertAction($id,Request $request)
    {
        $libelle = $request->get('libelle');
        $type = $request->get('type');
        $description = $request->get('description');
        $valeur = $request->get('valeur');
        $id = $request->get('id');

        $sn = $this->get('doctrine_mongodb')->getManager();
        $alert = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);

        if (empty($alert)) {
            return new View("Vehicle not found", Response::HTTP_NOT_ACCEPTABLE);
        }

        $alert->setLibelle($libelle);
        $alert->setType($type);
        $alert->setDescription($description);
        $alert->setValeur($valeur);
        //$driver->setVehicle($vehicle);
        $sn->flush();
        return new View("Alert Updated Successfully", Response::HTTP_OK);
    }


    ///////////////////////////////////////
    /////       Get Alert  By Id      /////
    ///////////////////////////////////////


    /**
     * @Rest\Get("/alert/{id}")
     */
    public function GetAlertByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);
        if ($singleresult === null) {
            return new View("Alert not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    //////////////////////////////
    ////////  Activate  Alert  /////
    //////////////////////////////

    /**
     * @Rest\Put("/activateAlert/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function ActivateAlertAction($id,Request $request)
    {



        $alert = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);
        $sn = $this->get('doctrine_mongodb')->getManager();

        if (empty($alert)) {
            return new View("alert not found", Response::HTTP_NOT_FOUND);

        }

        $alert->setActive(true);
        $sn->merge($alert);
        $sn->flush();
        return new View("alert activated Successfully", Response::HTTP_OK);


    }
    ///////////////////////////////////
    ////////  Desactivate  Alert  /////
    ///////////////////////////////////

    /**
     * @Rest\Put("/desactivateAlert/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function DesactivateAlertAction($id,Request $request)
    {



        $alert = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);
        $sn = $this->get('doctrine_mongodb')->getManager();

        if (empty($alert)) {
            return new View("alert not found", Response::HTTP_NOT_FOUND);

        }

        $alert->setActive(false);
        $sn->merge($alert);
        $sn->flush();
        return new View("alert desactivated Successfully", Response::HTTP_OK);


    }




}
