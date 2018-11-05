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
     * @Rest\Get("/myflot/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmyVehicleAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);
        //var_dump($user->getCompany()->getId());die();
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();

        if(count($results)==0){
            $a=array();
            return($a);
        }
        foreach ($results as $result) {
            if($result->getFlot()->getComapny()->getId()==$user->getCompany()->getId()) {
                $formatted[] = [
                    'reg_number' => $result->getRegNumber(),
                    'flot' => $result->getFlot(),
                    'libele' => $result->getLibele(),
                    'adress' => $result->getAdress(),
                    'type_carburant' => $result->getFuelType(),
                    'reservoir' => $result->getReservoir(),
                    'id' => $result->getId(),
                    'type' => $result->getType(),
                    'mark' => $result->getMark(),
                    'model' => $result->getModel(),
                    'fuel_type' => $result->getFuelType(),
                    'puissance' => $result->getPuissance(),
                    'rpmMax' => $result->getRpmMax(),
                    'videngekm' => $result->getVidengekm(),
                    'videngetime' => $result->getVidengetime(),
                    'nom' => $result->getNom(),
                    'prenom' => $result->getPrenom(),
                    'positionx' => $result->getPositionx(),
                    'positiony' => $result->getPositiony(),
                    'technical_visit' => date('Y-m-d', $result->getTechnicalVisit()->sec),
                    'insurance' => date('Y-m-d', $result->getInsurance()->sec),
                    'vignettes' => date('Y-m-d', $result->getVignettes()->sec),
                ];
            }
        }
        return ($formatted);
    }

    /**
     * @Rest\Get("/mybflot/{id}",name="hfgealfh")
     * @param Request $request
     * @return view
     */
    public function getmyrealVehicleAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);
        //var_dump($user->getCompany()->getId());die();
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();

        if(count($results)==0){
            $a=array();
            return($a);
        }
        $formatted=[];
        foreach ($results as $result) {
            if($result->getFlot()->getComapny()->getId()==$user->getCompany()->getId() &&
                (!empty($result->getBox()) || $result->getBox() != null)
                && $result->getType()!="personne" && $result->getType()!="depot"
                ) {
                $formatted[] = [
                    'reg_number' => $result->getRegNumber(),
                    'flot' => $result->getFlot()->getId(),
                    'box' => $result->getBox()->getImei(),
                    //'libele' => $result->getLibele(),
                    //'adress' => $result->getAdress(),
                    'type_carburant' => $result->getFuelType(),
                    'reservoir' => $result->getReservoir(),
                    'id' => $result->getId(),
                    'type' => $result->getType(),
                    'mark' => $result->getMark(),
                    'model' => $result->getModel(),
                    'fuel_type' => $result->getFuelType(),
                    'puissance' => $result->getPuissance(),
                    'rpmMax' => $result->getRpmMax(),
                    'videngekm' => $result->getVidengekm(),
                    'videngetime' => $result->getVidengetime(),
                    'nom' => $result->getNom(),
                    'prenom' => $result->getPrenom(),
                    'positionx' => $result->getPositionx(),
                    'positiony' => $result->getPositiony(),
                    'technical_visit' => date('Y-m-d', $result->getTechnicalVisit()->sec),
                    'insurance' => date('Y-m-d', $result->getInsurance()->sec),
                    'vignettes' => date('Y-m-d', $result->getVignettes()->sec),
                ];
            }
        }
        return ($formatted);
    }

    /**
     * @Rest\Get("/vehicle")
     */
    public function getVehicleAction()
    {

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->findAll();
        $formatted = [];
        foreach ($results as $result) {
            //$b = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($result->getBox()->getId());
            //$t = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->findByBox($b);

            $box = $result->getBox();
            //dump($box);die();
            if ($box){
            $formatted[] = [
                'reg_number' => $result->getRegNumber(),
                'imei' => $box->getImei(),
                'type_carburant' => $result->getFuelType(),
                /*'reservoir' => $result->getReservoir(),
                'id' => $result->getId(),
                'fuel_consumed' => $t[count($t)-1]->getFeelConsumed(),
                'time_stamp' => $t[count($t)-1]->getTimestamp(),
                'fuel_lvl' => $t[count($t)-1]->getFeelLvl(),
                'fuel_lvlp' => $t[count($t)-1]->getFeelLvlp(),*/

            ];
            }
            else{
                $formatted[] = [
                    'reg_number' => $result->getRegNumber(),
                    'type_carburant' => $result->getFuelType(),
                    /*'reservoir' => $result->getReservoir(),
                    'id' => $result->getId(),
                    'fuel_consumed' => $t[count($t)-1]->getFeelConsumed(),
                    'time_stamp' => $t[count($t)-1]->getTimestamp(),
                    'fuel_lvl' => $t[count($t)-1]->getFeelLvl(),
                    'fuel_lvlp' => $t[count($t)-1]->getFeelLvlp(),*/

                ];
            }

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
        $libele = $request->get('libele');
        $adress = $request->get('adress');
        $videngekm = $request->get('videngekm');
        $videngetime = $request->get('videngetime');
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $positionx = $request->get('positionx');
        $positiony = $request->get('positiony');
        $matricule = $request->get('reg_number');
        $type = $request->get('type');
        $reservoir = $request->get('reservoir');
        $typeCarburant = $request->get('fuel_type');
        $idmark = $request->get('mark');
        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $idBoitier = $request->get('box');
        $insurance = strtotime(substr($request->get('insurance'),0,24));
        $vignettes = strtotime(substr($request->get('vignettes'),0,24));
        $technical_visit = strtotime(substr($request->get('technical_visit'),0,24));
        $idmodele =  $request->get('model');
        $idflot =  $request->get('fleet');
        if($idBoitier==null) {
            $boitier = null;
        }else {
            $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idBoitier);
        }
        $fleet = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->find($idflot);

        //var_dump($boitier);die();


        $data->setLibele($libele);
        $data->setAdress($adress);
        $data->setNom($nom);
        $data->setPrenom($prenom);
        $data->setPositionx($positionx);
        $data->setPositiony($positiony);
        $data->setInsurance($insurance);
        $data->setVignettes($vignettes);
        if(!empty($fleet)) {
            $data->setFlot($fleet);
        }
        $data->setVidengekm($videngekm);
        $data->setVidengetime($videngetime);
        $data->setTechnicalVisit($technical_visit);
        $data->setRegNumber($matricule);
        $data->setBox($boitier);
        $data->setType($type);
        $data->setPuissance($puissance);
        $data->setReservoir($reservoir);
        $data->setRpmMax($rpmMax);
        $data->setFuelType($typeCarburant);
        $data->setMark($idmark);
        $data->setModel($idmodele);

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
        $videngekm = $request->get('videngekm');
        $videngetime = $request->get('videngetime');
        $matricule = $request->get('reg_number');
        $reservoir = $request->get('reservoir');
        $typeCarburant = $request->get('type_carburant');
        $idmark = $request->get('idmark');

        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $idmodele =  $request->get('idmodel');
        $insurance = strtotime(substr($request->get('insurance'),0,24));
        $vignettes = strtotime(substr($request->get('vignettes'),0,24));
        $technical_visit = strtotime(substr($request->get('technical_visit'),0,24));
        $idBoitier = $request->get('box');
        if($idBoitier==null){
            $boitier=null;
        }else {
            $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idBoitier);
        }
        $type = $request->get('type');
        $sn = $this->get('doctrine_mongodb')->getManager();
        $vehicule = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($id);
        $mark = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Mark')->find($idmark);
        $model = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Model')->find($idmodele);

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
            $vehicule->setVidengetime($videngetime);
            $vehicule->setVidengekm($videngekm);
            $vehicule->setPuissance($puissance);
            $vehicule->setReservoir($reservoir);
            $vehicule->setRpmMax($rpmMax);
            $vehicule->setFuelType($typeCarburant);
            $vehicule->setMark($mark);
            $vehicule->setModel($model);
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
     * @Rest\Put("/assignf/{id}",)
     * @param $id
     * @param Request $request
     * @return string
     */
    public function assigntoflotteAction($id,Request $request)
    {
        $matricule = $request->get('reg_number');
        $reservoir = $request->get('reservoir');
        $typeCarburant = $request->get('type_carburant');
        $idmark = $request->get('idmark');

        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $idmodele =  $request->get('idmodel');
        $insurance = strtotime(substr($request->get('insurance'),0,24));
        $vignettes = strtotime(substr($request->get('vignettes'),0,24));
        $technical_visit = strtotime(substr($request->get('technical_visit'),0,24));
        $idBoitier = $request->get('box');
        if($idBoitier==null){
            $boitier=null;
        }else {
            $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idBoitier);
        }
        $type = $request->get('type');
        $sn = $this->get('doctrine_mongodb')->getManager();
        $vehicule = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($id);
        $mark = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Mark')->find($idmark);
        $model = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Model')->find($idmodele);

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
        $vehicule->setMark($mark);
        $vehicule->setModel($model);
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
     * @Rest\Get("/vehicledates/{id}/{datemin}/{datemax}", name="date")
     * @param Request $request
     * @return array
     */
    public function getVehicleBetweenTwoDatesAction(Request $request)
    {

        $userID=$request->get('id');
        $datemin=$request->get('datemin');
        $datemax=$request->get('datemax');

        $allvehicle=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();

        $result= [];
        $resTrame=array();
        $c=0;
        for($i=0;$i<count($allvehicle);$i++) {
            if (!empty($allvehicle[$i]->getBox())){
                $trames = $allvehicle[$i]->getBox()->getTrame();
            for ($j = 0; $j < count($trames); $j++) {

                if ((date('Y-m-d', $trames[$j]->getTimestamp()) > $datemin) &&
                    (date('Y-m-d', $trames[$j]->getTimestamp()) < $datemax)) {
                    $resTrame[$c] = $trames[$j];
                    $c++;
                }
            }
        }
        }

        for ($i=0;$i<count($resTrame);$i++){
            //$res =$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->findOneById($resTrame[$i]);
            $result[]=[
                'reg_number' => $resTrame[$i]->getBox()->getVehicle()->getRegNumber(),
                'timestamp' => date('Y-m-d H:i:s',$resTrame[$i]->getTimeStamp()) ,
                'longitude' => $resTrame[$i]->getLongitude(),
                'latitude' => $resTrame[$i]->getLatitude(),
            ];

        }

        return $result;

    }
    /**
     * @Rest\Get("/allvehicle")
     * @param Request $request
     * @return array
     */
    public function getAllVehiclebyAction(Request $request)
    {


        $results = $this->get('doctrine_mongodb')->
        getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();



        return $results;
    }
    /**
     * @Rest\Get("/allnotboundvehicle")
     * @param Request $request
     * @return array
     */
    public function getAllVehiclenotboundAction(Request $request)
    {


        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);
        //var_dump($user->getCompany()->getId());die();
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();

        if(count($results)==0){
            $a=array();
            return($a);
        }
        foreach ($results as $result) {
            if(
             empty($result->getBox())) {
                $formatted[] = [
                    'reg_number' => $result->getRegNumber(),
                    'flot' => $result->getFlot(),
                    'type_carburant' => $result->getFuelType(),
                    'reservoir' => $result->getReservoir(),
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),
                    'adress' => $result->getAdress(),
                    'type' => $result->getType(),
                    'mark' => $result->getMark(),
                    'model' => $result->getModel(),
                    'fuel_type' => $result->getFuelType(),
                    'puissance' => $result->getPuissance(),
                    'rpmMax' => $result->getRpmMax(),
                    'videngekm' => $result->getVidengekm(),
                    'videngetime' => $result->getVidengetime(),
                    'nom' => $result->getNom(),
                    'prenom' => $result->getPrenom(),
                    'positionx' => $result->getPositionx(),
                    'positiony' => $result->getPositiony(),
                    'technical_visit' => date('Y-m-d', $result->getTechnicalVisit()->sec),
                    'insurance' => date('Y-m-d', $result->getInsurance()->sec),
                    'vignettes' => date('Y-m-d', $result->getVignettes()->sec),
                ];
            }
        }
        return ($formatted);
    }
    /**
     * @Rest\Get("/allboundvehicle")
     * @param Request $request
     * @return array
     */
    public function getAllVehicleboundAction(Request $request)
    {


        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);
        //var_dump($user->getCompany()->getId());die();
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();

        if(count($results)==0){
            $a=array();
            return($a);
        }
        foreach ($results as $result) {
            if(
            !empty($result->getBox())) {
                $formatted[] = [
                    'reg_number' => $result->getRegNumber(),
                    'flot' => $result->getFlot(),
                    'type_carburant' => $result->getFuelType(),
                    'reservoir' => $result->getReservoir(),
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),
                    'adress' => $result->getAdress(),
                    'type' => $result->getType(),
                    'mark' => $result->getMark(),
                    'model' => $result->getModel(),
                    'fuel_type' => $result->getFuelType(),
                    'puissance' => $result->getPuissance(),
                    'rpmMax' => $result->getRpmMax(),
                    'videngekm' => $result->getVidengekm(),
                    'videngetime' => $result->getVidengetime(),
                    'nom' => $result->getNom(),
                    'prenom' => $result->getPrenom(),
                    'positionx' => $result->getPositionx(),
                    'positiony' => $result->getPositiony(),
                    'technical_visit' => date('Y-m-d', $result->getTechnicalVisit()->sec),
                    'insurance' => date('Y-m-d', $result->getInsurance()->sec),
                    'vignettes' => date('Y-m-d', $result->getVignettes()->sec),
                ];
            }
        }
        return ($formatted);
    }
    /**
     * @Rest\Get("/myvehicle/{id}")
     * @param Request $request
     * @return array
     */
    public function getVehiclebyAction(Request $request)
    {
        $userID=$request->get('id');

        $results = $this->get('doctrine_mongodb')->
        getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findOneBy(array('reg_number'=>$userID));



        return $results;
    }

}
