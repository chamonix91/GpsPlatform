<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

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
                'type_carburant' => $result->getFuelType(),
                'reservoir' => $result->getReservoir(),
                'id' => $result->getId(),
                'fuel_consumed' => $t[count($t)-1]->getFeelConsumed(),
                'time_stamp' => $t[count($t)-1]->getTimestamp(),
                'fuel_lvl' => $t[count($t)-1]->getFeelLvl(),
                'fuel_lvlp' => $t[count($t)-1]->getFeelLvlp(),

            ];
        }

        return $formatted;
    }

    /**
     * @Rest\Post("/vehicle",name="_add")
     * @param Request $request
     * @return string
     */
    public function postVehicleAction(Request $request)
    {
        $data = new Vehicle();
        $matricule = $request->get('reg_number');
        $type = $request->get('type');
        $reservoir = $request->get('reservoir');
        $typeCarburant = $request->get('type_carburant');
        $marque = $request->get('mark');
        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $idBoitier = $request->get('box');
        $insurance = $request->get('insurance');
        $vignettes = $request->get('vignettes');
        $technical_visit = $request->get('technical_visit');
        $modele =  $request->get('model');
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
        $data->setFuelType($typeCarburant);
        $data->setMark($marque);
        $data->setModel($modele);
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
        $typeCarburant = $request->get('type_carburant');
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
        $vehicule->setFuelType($typeCarburant);
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
     * @Rest\Post("/vehicledates", name="date")
     * @param Request $request
     * @return array
     */
    public function getVehicleBetweenTwoDatesAction(Request $request)
    {
        //$user = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:User')->findById($userID);
        //$allvehicle=$user->getCompany()->getVehicles();
        $datemin=$request->get('datemin');
        $datemax=$request->get('datemax');
        $allvehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->findAll();


        $result= [];
        $resTrame=array();
        $c=0;
        for($i=0;$i<count($allvehicle);$i++){
            $trames=$allvehicle[$i]->getBox()->getTrame();
            for ($j=0;$j<count($trames);$j++){
                //$time= Date("d-m-Y",$trames[$j]->getTimestamp());
                if(($trames[$j]->getTimestamp() > $datemin) || ($trames[$j]->getTimestamp()< $datemax) ){
                    $resTrame[$c]=$trames[$j]->getId();
                    $c++;
                }
            }
        }

        for ($i=0;$i<count($resTrame);$i++){
            $res =$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->findOneById($resTrame[$i]);
            $result[]=[
                'reg_number' => $res->getBox()->getVehicle()->getRegNumber(),
                'imei' => $res->getBox()->getImei(),
                'type_carburant' => $res->getBox()->getVehicle()->getFuelType(),
                'reservoir' => $res->getBox()->getVehicle()->getReservoir(),
                'idVehicle' => $res->getBox()->getVehicle()->getId(),
                'idTrame' => $res->getId(),
                'timestamp' => $res->getTimeStamp(),
                'fuel_consumed' => $res->getFeelConsumed(),
                'fuel_lvl' => $res->getFeelLvl(),
                'fuel_lvlp' => $res->getFeelLvlp(),
            ];

        }

        return $result;

    }

}
