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
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->findAll();
        $formatted = [];
        foreach ($results as $result) {
            $b = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($result->getBox()->getId());
            $t = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->findByBox($b);

            $formatted[] = [
                'reg_number' => $result->getRegNumber(),
                'imei' => $result->getBox()->getImei(),
                'type_carburant' => $result->getTypeCarburant(),
                'reservoir' => $result->getReservoir(),
                'id' => $result->getId(),
                'fuel_consumed' => $t[count($t)-1]->getFeelConsumed(),
                'time_stamp' => $t[count($t)-1]->getTimestamp(),
                'speed' => $t[count($t)-1]->getSpeed(),
                'fuel_lvl' => $t[count($t)-1]->getFeelLvl(),
                'fuel_lvlp' => $t[count($t)-1]->getFeelLvlp(),
                 'engine_work_time' => $t[count($t)-1]->getEngineworktime(),
                'engine_worktime_counted' => $t[count($t)-1]->getEngineworktimecounted(),
                'engine_load' => $t[count($t)-1]->getEngineload(),
                'batterie_lvl' => $t[count($t)-1]->getBatrieLvl(),

                //'id' => $result->getId(),
               // 'id' => $result->getId(),
               // 'type_carburant' => $result->getTypeCarburant(),

            ];
        }

        return $formatted;
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
        $reservoir = $request->get('reservoir');
        //$typeCarburant = $request->get('typeCarburant');
        $marque = $request->get('mark');
        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $idBoitier = $request->get('box');
        $modele =  $request->get('model');
        $insurance = $request->get('insurance');
        $vignettes = $request->get('vignettes');
        $technical_visit = $request->get('technical_visit');
        $idcompany = $request->get('company');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
        $modele =  $request->get('modele');
        $idCompany= $request->get('company');
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idBoitier);
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idCompany);

        //var_dump($boitier);die();
        if(empty($matricule)|| empty($type))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setInsurance($insurance);
        $data->setVignettes($vignettes);
        $data->setTechnicalVisit($technical_visit);
        $data->setCompany($company);
        $data->setRegNumber($matricule);
        $data->setBox($boitier);
        $data->setType($type);
        $data->setPuissance($puissance);
        $data->setReservoir($reservoir);
        $data->setRpmMax($rpmMax);
        $data->setTypeCarburant($typeCarburant);
        $data->setMarque($marque);
        $data->setModele($modele);
        $data->setCompany($company);

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
        $reservoir = $request->get('reservoir');
        $typeCarburant = $request->get('typeCarburant');
        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $technical_visit = $request->get('technical_visit');
        $insurance = $request->get('insurance');
        $vignettes = $request->get('vignettes');
        $idBoitier = $request->get('box');
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idBoitier);
        $type = $request->get('type');
        $sn = $this->get('doctrine_mongodb')->getManager();
        $vehicule = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($id);

        if (empty($vehicule)) {
            return new View("Vehicle not found", Response::HTTP_NOT_ACCEPTABLE);
        }


       // elseif(!empty($matricule) && !empty($idBoitier)&& !empty($type)){
            $vehicule->setTechnicalVisit($technical_visit);
            $vehicule->setVignettes($vignettes);
            $vehicule->setInsurance($insurance);
            $vehicule->setRegNumber($matricule);
            $vehicule->setBox($boitier);
            $vehicule->setType($type);
        $vehicule->setPuissance($puissance);
        $vehicule->setReservoir($reservoir);
        $vehicule->setRpmMax($rpmMax);
        $vehicule->setTypeCarburant($typeCarburant);
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

    /**
     * @Rest\Get("/vehicle/{idc}")
     * @param $idc
     * @return  Vehicle|null|object
     */
    public function getVehiculeBetweentwodates($datemin,$datemax)
    {
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->findAll();


    }

}
