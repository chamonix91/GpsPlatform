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
            if(empty($result->getRadus())){
                $result->setRadus("-");
            }
            $formatted1=null;
            if(count($result->getVehicle())>0) {
                foreach ($result->getVehicle() as $vehicle) {
                    $formatted1[] = [
                        'reg_number' => $vehicle->getRegNumber(),
                        //'flot' => $result->getFlot(),
                        'libele' => $vehicle->getLibele(),
                        'adress' => $vehicle->getAdress(),
                        'type_carburant' => $vehicle->getFuelType(),
                        'reservoir' => $vehicle->getReservoir(),
                        'id' => $vehicle->getId(),
                        'type' => $vehicle->getType(),
                        'mark' => $vehicle->getMark(),
                        'model' => $vehicle->getModel(),
                        'fuel_type' => $vehicle->getFuelType(),
                        'puissance' => $vehicle->getPuissance(),
                        'rpmMax' => $vehicle->getRpmMax(),
                        'videngekm' => $vehicle->getVidengekm(),
                        'videngetime' => $vehicle->getVidengetime(),
                        'nom' => $vehicle->getNom(),
                        'prenom' => $vehicle->getPrenom(),
                        'positionx' => $vehicle->getPositionx(),
                        'positiony' => $vehicle->getPositiony(),
                        'technical_visit' => date('Y-m-d', $vehicle->getTechnicalVisit()->sec),
                        'insurance' => date('Y-m-d', $vehicle->getInsurance()->sec),
                        'vignettes' => date('Y-m-d', $vehicle->getVignettes()->sec),
                    ];
                }
            }
            else{
                $formatted1 = null;
            }
            if (!empty($result->getCompany()) || $result->getCompany() != null)
            {  $formatted = [
                    'id' => $result->getCompany()->getId(),
                    'name' => $result->getCompany()->getName(),
                    'adress' => $result->getCompany()->getAdress(),
                    'phone' => $result->getCompany()->getPhone(),
                    'created_date' => $result->getCompany()->getCreatedDate(),
                    'end_date' => strtotime($result->getCompany()->getEndDate()),
                    'cp_name' => $result->getCompany()->getCpName(),
                    'cp_phone' => $result->getCompany()->getCpPhone(),
                    'cpa_name' => $result->getCompany()->getCpaName(),
                    'cpa_phone' => $result->getCompany()->getCpaPhone(),
                ];

                $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibelle(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                    'valeur1' => $result->getValeur1(),
                    'radus' => $result->getRadus(),
                    'company' => $formatted,
                    'active' => $result->getActive(),
                    'object' => $formatted1,
                    'objectc' => count($result->getVehicle()),
                    'objectc1' => count($formatted1),
                ];
            }else{
                $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibelle(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                    'valeur1' => $result->getValeur1(),
                    'radus' => $result->getRadus(),
                    'active' => $result->getActive(),
                    'object' => $formatted1,
                    'objectc' => count($result->getVehicle()),
                    'objectc1' => count($formatted1),
                ];
            }

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

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')
            ->findBy(array('company' => $user->getCompany()));

        if ($results === null) {
            return new View("there are no alerts exist", Response::HTTP_NOT_FOUND);
        }
        foreach ($results as $result) {
            $formatted1=null;
            if(count($result->getVehicle())>0) {
                foreach ($result->getVehicle() as $vehicle) {
                    $formatted1[] = [
                        'reg_number' => $vehicle->getRegNumber(),
                        //'flot' => $result->getFlot(),
                        'libele' => $vehicle->getLibele(),
                        'adress' => $vehicle->getAdress(),
                        'type_carburant' => $vehicle->getFuelType(),
                        'reservoir' => $vehicle->getReservoir(),
                        'id' => $vehicle->getId(),
                        'type' => $vehicle->getType(),
                        'mark' => $vehicle->getMark(),
                        'model' => $vehicle->getModel(),
                        'fuel_type' => $vehicle->getFuelType(),
                        'puissance' => $vehicle->getPuissance(),
                        'rpmMax' => $vehicle->getRpmMax(),
                        'videngekm' => $vehicle->getVidengekm(),
                        'videngetime' => $vehicle->getVidengetime(),
                        'nom' => $vehicle->getNom(),
                        'prenom' => $vehicle->getPrenom(),
                        'positionx' => $vehicle->getPositionx(),
                        'positiony' => $vehicle->getPositiony(),
                        'technical_visit' => date('Y-m-d', $vehicle->getTechnicalVisit()->sec),
                        'insurance' => date('Y-m-d', $vehicle->getInsurance()->sec),
                        'vignettes' => date('Y-m-d', $vehicle->getVignettes()->sec),
                    ];
                }
            }
            else{
                $formatted1 = null;
            }
            if (!empty($result->getCompany()) || $result->getCompany() != null)
            {  $formatted = [
                'id' => $result->getCompany()->getId(),
                'name' => $result->getCompany()->getName(),
                'adress' => $result->getCompany()->getAdress(),
                'phone' => $result->getCompany()->getPhone(),
                'created_date' => $result->getCompany()->getCreatedDate(),
                'end_date' => strtotime($result->getCompany()->getEndDate()),
                'cp_name' => $result->getCompany()->getCpName(),
                'cp_phone' => $result->getCompany()->getCpPhone(),
                'cpa_name' => $result->getCompany()->getCpaName(),
                'cpa_phone' => $result->getCompany()->getCpaPhone(),
            ];

                $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibelle(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                    'valeur1' => $result->getValeur1(),
                    'radus' => $result->getRadus(),
                    'company' => $formatted,
                    'active' => $result->getActive(),
                    'object' => $formatted1,
                    'objectc' => count($result->getVehicle()),
                    'objectc1' => count($formatted1),
                ];
            }else{
                $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibelle(),
                    'type' => $result->getType(),
                    'description' => $result->getDescription(),
                    'valeur' => $result->getValeur(),
                    'valeur1' => $result->getValeur1(),
                    'radus' => $result->getRadus(),
                    'active' => $result->getActive(),
                    'object' => $formatted1,
                    'objectc' => count($result->getVehicle()),
                    'objectc1' => count($formatted1),
                ];
            }

        }


        return $drivers;

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
        $valeur1 = $request->get('valeur1');
        $zone = $request->get('radus');
        $idcompany = $request->get('idcompany');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);




        //var_dump($boitier);die();
        if(empty($libelle)|| empty($type)  )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibelle($libelle);
        $data ->setActive(true);
        $data ->setType($type);
        $data ->setRadus($zone);
        $data->setValeur($valeur);
        $data->setValeur1($valeur1);
        $data->setDescription($description);
        if(!empty($company))
            $data->setCompany($company);

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
        $valeur1 = $request->get('valeur1');
        $zone= $request->get('radus');
        $idcompany = $request->get('id');

            $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);


        if(empty($libelle)|| empty($type) || empty($valeur) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibelle($libelle);
        $data ->setType($type);
        $data ->setRadus($zone);
        $data->setValeur($valeur);
        $data->setValeur1($valeur1);
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
        $zone = $request->get('radus');
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
        $alert->setRadus($zone);
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

    /**
     * @Rest\Put("/affectAlerttoclient/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function AffecttoclientAlertAction($id,Request $request)
    {



        $alert = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);
        $idclient = $request->get('idclient');
        $client = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($idclient);
        $sn = $this->get('doctrine_mongodb')->getManager();

        if (empty($alert)) {
            return new View("alert not found", Response::HTTP_NOT_FOUND);

        }

        $alert->setActive(true);
        $alert->setCompany($client);
        $sn->merge($alert);
        $sn->flush();
        return new View("alert activated Successfully", Response::HTTP_OK);


    }
    /**
     * @Rest\Put("/affectAlerttoobject/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function AffecttoojectAlertAction($id,Request $request)
    {



        $alert = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);
        $idobject = $request->get('idobject');
        $object = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->find($idobject);
        $idclient = $request->get('idclient');
        $client = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($idclient);
        $sn = $this->get('doctrine_mongodb')->getManager();

        if (empty($alert)) {
            return new View("alert not found", Response::HTTP_NOT_FOUND);

        }
        var_dump($alert);
        $alert->setActive(true);
        $alert->setVehicle($object);
        $alert->setCompany($client);
        $sn->merge($alert);
        var_dump($alert);
        $sn->flush();
        return new View("alert activated Successfully", Response::HTTP_OK);


    }
    /**
     * @Rest\Put("/affectAlerttoobjectclient/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function AffecttoojectAlertclientAction($id,Request $request)
    {



        $alert = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Alert')->find($id);
        $idobject = $request->get('idobject');
        $object = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->find($idobject);

        $sn = $this->get('doctrine_mongodb')->getManager();

        if (empty($alert)) {
            return new View("alert not found", Response::HTTP_NOT_FOUND);

        }

        $alert->setActive(true);
        $alert->remove();
        $alert->setVehicle($object);
        $sn->merge($alert);
        $sn->flush();
        return new View("alert activated Successfully", Response::HTTP_OK);


    }




}
