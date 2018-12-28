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
                    //'flot' => $result->getFlot(),
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
    public function idBoxtrames($id)
    {

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')
            ->findBy(array('box' => $id));
        if ($result === null) {
            return null;
        }
        foreach ($result as $user) {
            $formatted[] = [
                'id' => $user->getId(),
                'timestamp' => $user->getTimestamp(),
                'street' => $user->getStreet(),
                'longitude' => $user->getLongitude(),
                'latitude' => $user->getLatitude(),
                'angle' => $user->getAngle(),
                'speed' => $user->getSpeed(),
                'contact' => $user->getContact(),
                'din1' => $user->getContact(),
                'box' => $user->getBox()->getImei(),

            ];
        }
        //var_dump(count($formatted));die();
        if(count($result)==0)
            return null;
        else
            return $formatted;
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

        /*************/
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
                $capteurs = array();
                foreach ($result->getCapteurs() as $cap){
                    $capteurs[] = [
                        'id' => $cap->getId(),
                        'nom' => $cap->getNom(),
                        'key1' => $cap->getKey1(),
                        'key2' => $cap->getKey2(),
                        'description' => $cap->getDescription(),
                        'ioement' => $cap->getIoement(),
                        'valeur1' => $cap->getValeur1(),
                        'valeur2' => $cap->getValeur2(),
                        'type' => $cap->getType(),
                    ];

                }
                $trams=$this->idBoxtrames($result->getBox());

                //var_dump([count($trams)]->getId());die();
                if(count($trams)>0) {
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'flot' => $result->getFlot()->getId(),
                        'box' => $result->getBox()->getImei(),
                        'trams' => ($trams),
                        'ctrams' => count($trams),
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
                        'capteurs' => ($capteurs),
                        'technical_visit' => date('Y-m-d', $result->getTechnicalVisit()->sec),
                        'insurance' => date('Y-m-d', $result->getInsurance()->sec),
                        'vignettes' => date('Y-m-d', $result->getVignettes()->sec),
                        'lastposition' => $trams[count($trams) - 1]['street'],
                    ];
                }
                else{
                        $formatted[] = [
                            'reg_number' => $result->getRegNumber(),
                            'flot' => $result->getFlot()->getId(),
                            'box' => $result->getBox()->getImei(),
                            'capteurs' => ($capteurs),
                            'trams' => ($trams),
                            'ctrams' => count($trams),
                            //'last'=>$trams[count($trams)-1]->getLongitude(),
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
                            //'lastposition' => $trams[count($trams) - 1]->getStreet(),
                        ];

                }
            }
        }

        return ($formatted);
    }


    /**
     * @Rest\Get("/mybbflot",name="dddd")
     * @param Request $request
     * @return view
     */
    public function getallVehicleAction(Request $request)
    {

        //var_dump($user->getCompany()->getId());die();

        /*************/
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();

        if(count($results)==0){
            $a=array();
            return($a);
        }
        $formatted=[];
        foreach ($results as $result) {
            if( (!empty($result->getComapny()) || $result->getComapny() != null) &&
                $result->getType()!="personne" && $result->getType()!="depot"
            ) {
                $trams=$this->idBoxtrames($result->getBox());

                //var_dump([count($trams)]->getId());die();
                if(count($trams)>0) {
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'flot' => $result->getFlot()->getId(),
                        'company' => $result->getComapny()->getId(),
                        'trams' => ($trams),
                        'ctrams' => count($trams),
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
                        'lastposition' => $trams[count($trams) - 1]['street'],
                    ];
                }
                else{
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'flot' => $result->getFlot()->getId(),
                        'trams' => ($trams),
                        'ctrams' => count($trams),
                        'company' => $result->getComapny()->getId(),
                        //'last'=>$trams[count($trams)-1]->getLongitude(),
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
                        //'lastposition' => $trams[count($trams) - 1]->getStreet(),
                    ];

                }
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

        return $results;
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
        /*$user=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($userID);*/
        $datemin=$request->get('datemin');
        $datemax=$request->get('datemax');

        $allvehicle=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();
        $result= [];
        $resTrame=array();
        $c=0;
        for($i=0;$i<count($allvehicle);$i++) {
            if ((!empty($allvehicle[$i]->getBox()) || $allvehicle[$i]->getBox() != null)
                && $allvehicle[$i]->getFlot()->getComapny()->getId()==$userID ){
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
            /*$s = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" . $resTrame[$i]->getLatitude()
                . "&lon=" . $resTrame[$i]->getLongitude() . "&accept-language=fr";

            $options = array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
                )
            );
            $context = stream_context_create($options);
            $resultj = file_get_contents($s, true, $context);
            $obj = json_decode($resultj);*/
            $result[]=[
                'reg_number' => $resTrame[$i]->getBox()->getVehicle()->getRegNumber(),
                //'adress' => $obj->display_name,
                'adress' =>$resTrame[$i]->getStreet(),
                'timestamp' => date('Y-m-d H:i:s',$resTrame[$i]->getTimeStamp()) ,
                'date' => date('Y-m-d H:i:s', $resTrame[$i]->getTimeStamp()),
                'longitude' => $resTrame[$i]->getLongitude(),
                'latitude' => $resTrame[$i]->getLatitude(),
                'speed' => $resTrame[$i]->getSpeed(),
                'contact' => $resTrame[$i]->getContact(),
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
                    //'flot' => $result->getFlot(),
                    'company' => $result->getFlot()->getComapny()->getId(),
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
        $formatted[]=[];
        foreach ($results as $result) {
            if(
            !empty($result->getBox())) {
                $formatted[] = [
                    'reg_number' => $result->getRegNumber(),
                    //'box' => $result->getFlot(),
                    'company' => $result->getFlot()->getComapny()->getId(),
                    //'flot' => $result->getFlot(),
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


    /**
     * @Rest\Get("/historic/{id}/{startdate}/{enddate}/",name="his")
     */
    public function getTramesBydateAction(Request $request)
    {
        //var_dump("aaaaaaa");die();
        $id = $request->get('id');
        $startdate = $request->get('startdate');
        $enddate = $request->get('startdate');

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $company = $user->getCompany();
        $mybox = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->findBy(array('company'=>$company));
        var_dump(count($mybox[0]->getTrame()));die();
        //$fleets = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
        /*$fleets=array();
        $allfleets = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findAll();

        if ($fleets === null) {
            return new View("there are no fleets exist", Response::HTTP_NOT_FOUND);
        }
        //var_dump($allfleets);die();
        foreach ($allfleets as $fleet){
            if($fleet->getComapny()->getId()==$company->getId()){
                array($fleets,$fleet);
            }
        }
        //$vehicles= array();
        $trames = array();

        foreach ($fleets as $fleet){

            $vehicles = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
                ->findBy(array('fleet'=>$fleet));

            foreach ($vehicles as $vehicle){
                array_push($trames,$vehicle->getBox()->getTrame());
            }


        }

        $resTrame=array();
        $i = 0;
        for ($j = 0; $j < count($trames); $j++) {

            if ((date('Y-m-d', $trames[$j]->getTimestamp()) > $startdate) &&
                (date('Y-m-d', $trames[$j]->getTimestamp()) < $enddate)) {
                $resTrame[$i] = $trames[$j];
                $i++;
            }
        }

        for ($k=0;$k<count($resTrame);$k++){
            $result[]=[
                'reg_number' => $resTrame[$k]->getBox()->getVehicle()->getRegNumber(),
                'timestamp' => date('Y-m-d H:i:s',$resTrame[$k]->getTimeStamp()) ,
                'longitude' => $resTrame[$k]->getLongitude(),
                'latitude' => $resTrame[$k]->getLatitude(),
            ];

        }
        return $result;*/
    }

}
