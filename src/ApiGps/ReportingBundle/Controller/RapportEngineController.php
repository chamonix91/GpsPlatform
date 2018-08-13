<?php

namespace ApiGps\ReportingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class RapportEngineController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/rapportengine")
     */
    public function getVehicleAction()
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->findAll();
        /*for($i=0;$i<count($result);$i++){
            $lcp[] = [
                'nom' => $result[$i]->getRegNumber(),
                'mail' => $result[$i]->getMark(),
                'prenom' => $result[$i]->getModel(),
                'cin' => $result[$i]->getPuissance(),
                'rib' => $result[$i]->getRpmMax(),
            ];
        }*/
        return $result;
    }
}
