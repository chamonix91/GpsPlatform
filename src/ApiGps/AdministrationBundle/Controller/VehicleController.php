<?php

namespace ApiGps\AdministrationBundle\Controller;


use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class VehicleController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    /**
     * @Rest\Get("/vehicle")
     */
    public function getVehicleAction()
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->findAll();
        return $result;
    }

    /**
     * @Rest\Get("/vehicle/{id}")
     * @param $id
     * @return Vehicle|null|object
     */
    public function idVehicleAction($id)
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($id);
        return $result;
    }


    /**
     * @Rest\Post("/vehicle")
     * @param Request $request
     * @return string
     */
        public function postVehicleAction(Request $request)
    {
        $data = new Vehicle();
        $matricule = $request->get('reg_number');
        $type = $request->get('type');
        $idBoitier = $request->get('box');
        if(empty($matricule)|| empty($type))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setRegNumber($matricule);
        $data->setBox($idBoitier);
        $data->setType($type);
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Vehicle added Successfully", Response::HTTP_OK);    }

    /**
     * @Rest\Put("/vehicle/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updateVehicleAction($id,Request $request)
    {
        $matricule = $request->get('reg_number');
        $idBoitier = $request->get('box');
        $type = $request->get('type');
        $sn = $this->get('doctrine_mongodb')->getManager();
        $vehicule = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($id);

        if (empty($vehicule)) {
            return new View("Vehicle not found", Response::HTTP_NOT_ACCEPTABLE);
        }


       // elseif(!empty($matricule) && !empty($idBoitier)&& !empty($type)){
            $vehicule->setRegNumber($matricule);
            $vehicule->setBox($idBoitier);
            $vehicule->setType($type);
            $sn->flush();
            return new View("Vehicle Updated Successfully", Response::HTTP_OK);
/*
        }
        elseif(empty($matricule) && !empty($idBoitier)){
            $vehicule->setIdBoitier($idBoitier);
            $sn->flush();
            return new View("ID Box Updated Successfully", Response::HTTP_OK);
        }
        elseif(!empty($matricule) && empty($idBoitier)){
            $vehicule->setMatricule($matricule);
            $sn->flush();
            return new View("reg_number Updated Successfully", Response::HTTP_OK);

        }
        else
            return new View("reg_number or Box cannot be empty", Response::HTTP_NOT_ACCEPTABLE);*/

    }
}
