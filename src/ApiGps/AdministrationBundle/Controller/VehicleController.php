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
        $x=0;
        foreach ($results as $result) {

            if(empty($result->getPanne()) || $result->getPanne() == false){
                $result->setPanne(false);
            }
            //var_dump($result);die();
            if($result->getFlot()->getComapny()->getId()==$user->getCompany()->getId()) {
                //var_dump($result->getMark());die();

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
                    'panne' => $result->getPanne(),
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
               $x++;
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
            $pos = strpos($user->getTimestamp(), "T");

            if($pos ==false){
                $az=date('Y-m-d H:i:s', $user->getTimestamp());

            }
            else{
                $az =str_replace("T", " ", $user->getTimestamp());
                $az =str_replace(".000Z", "", $az);
                $az =str_replace("-", "/", $az);
                $az =substr_replace($az ,"", -1);
                $az =substr($az, 1);
            }//daclofdeano
            $d2=date('Y-m-d',strtotime("-1 days"));


                if($az>$d2){
                    $formatted[] = [
                        'id' => $user->getId(),
                        'timestamp' => $az,
                        'street' => $user->getStreet(),
                        'longitude' => $user->getLongitude(),
                        'latitude' => $user->getLatitude(),
                        'angle' => $user->getAngle(),
                        'speed' => $user->getSpeed(),
                        'contact' => $user->getContact(),
                        'din1' => $user->getContact(),
                        'kilo' => $user->getTotalMileage(),
                        'box' => $user->getBox()->getImei(),

                    ];
                }

        }
        //var_dump(count($formatted));die();
        usort($formatted, function ($a, $b) {
            return $a['timestamp'] >= $b['timestamp'];
        });
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
        $imagess = $this->get('doctrine_mongodb')->getRepository
        ('ApiGpsAdministrationBundle:Mark')
            ->findAll();
        foreach ($imagess as $im){
            $images[]=[
              'name'=>$im->getName(),
              'image'=>$im->getImage(),
            ];
        }

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
                //var_dump($result->getMark());
                foreach ($images as $im){

                    if($im['name']==$result->getMark()){

                        $image=$im['image'];
                    }
                }
                $nameimage="";
                if(!empty($image))
                    $nameimage=$image;
                $capteurs = array();
                unset($capteurs);

                //var_dump(count($result->getCapteurs()));
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
                $trams=$this->idBoxtrames($result->getBox());//sweetydeano
                //var_dump(count($trams));
               // var_dump($result->getId());
                //var_dump([count($trams)]->getId());die();
                unset($operat);
                foreach ($result->getOperations() as $op){
                    $operat[] = [
                        'id' => $op->getId(),
                        'libele' => $op->getLibelle(),
                        'type' => $op->getType(),
                        'price' => $op->getPrice(),
                        'operation_date' => date('Y-m-d', $op->getOperationDate()->sec),
                    ];
                }
                unset($drivers);
                foreach ($result->getAlters() as $aler){
                    $drivers[] = [
                        'id' => $aler->getId(),
                        'libele' => $aler->getLibelle(),
                        'type' => $aler->getType(),
                        'description' => $aler->getDescription(),
                         'valeur' => $aler->getValeur(),
                        'valeur1' => $aler->getValeur1(),
                         'radus' => $aler->getRadus(),
                    ];
                }
                $d2=date('Y-m-d',strtotime("-2 days"));

                if(count($trams)>0) {

                    if(((strtotime(date('Y-m-d', strtotime($trams[count($trams) - 1]['timestamp'])))
                                <strtotime($d2))*-1)/86400){
                        $boxpanne=true;
                    }else{
                        $boxpanne=false;
                    }
                    //var_dump($result->getMark());

                        //->findOneBy(array("image"=>$result->getMark()));


                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'image' => $nameimage,
                        'boxpanne' => $boxpanne,
                        'alert' => $drivers,
                        'operation' => $operat,
                        'panne' => $result->getPanne(),
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
                        'timestamp' => $trams[count($trams) - 1]['timestamp'],

                        //'date' => $trams[count($trams) - 1]['timestamp'],
                        'date' => date('Y-m-d', strtotime($trams[count($trams) - 1]['timestamp'])),
                        'time' => date('H:i:s', strtotime($trams[count($trams) - 1]['timestamp'])),
                        'kilo' => $trams[count($trams) - 1]['kilo'],
                        //'time' => $trams[count($trams) - 1]['timestamp'],
                    ];
                }
                else{

                    $boxpanne=false;
                        $formatted[] = [
                            'reg_number' => $result->getRegNumber(),
                            'image' => $nameimage,
                            'alert' => $drivers,
                            'boxpanne' => $boxpanne,
                            'operation' => $operat,
                            'panne' => $result->getPanne(),
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
                            'lastposition' => "Non identifier",
                            'timestamp' => "Non identifier",
                            'date' => "Non identifier",
                            'time' => "Non identifier",
                            'kilo' => "Non identifier",
                        ];

                }
            }
        }
        //die();

        return ($formatted);
    }
    /**
     * @Rest\Get("/mydflot/{id}",name="hfgealfh")
     * @param Request $request
     * @return view
     */
    public function getmyrealdepotAction(Request $request)
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
            if($result->getFlot()->getComapny()->getId()==$user->getCompany()->getId()
                 && $result->getType()=="depot"
            ) {
                //var_dump($result->getMark());

                unset($capteurs);

                //var_dump(count($result->getCapteurs()));
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
               // $trams=$this->idBoxtrames($result->getBox());//sweetydeano
                // var_dump($result->getId());
                //var_dump([count($trams)]->getId());die();
                unset($operat);
                foreach ($result->getOperations() as $op){
                    $operat[] = [
                        'id' => $op->getId(),
                        'libele' => $op->getLibelle(),
                        'type' => $op->getType(),
                        'price' => $op->getPrice(),
                        'operation_date' => date('Y-m-d', $op->getOperationDate()->sec),
                    ];
                }
                $d2=date('Y-m-d',strtotime("-2 days"));

                //if(count($trams)>0) {
                if(0==0) {

                    //var_dump($result->getMark());

                    //->findOneBy(array("image"=>$result->getMark()));


                    $formatted[] = [
                        //'boxpanne' => $boxpanne,
                        'operation' => $operat,
                        'flot' => $result->getFlot()->getId(),
                        //'trams' => ($trams),
                        //'ctrams' => count($trams),
                        'id' => $result->getId(),
                        'type' => $result->getType(),
                        'nom' => $result->getLibele(),
                        'positionx' => $result->getPositionx(),
                        'positiony' => $result->getPositiony(),
                        'capteurs' => ($capteurs),
                        //'timestamp' => $trams[count($trams) - 1]['timestamp'],
                        //'date' => date('Y-m-d', strtotime($trams[count($trams) - 1]['timestamp'])),
                        //'time' => date('H:i:s', strtotime($trams[count($trams) - 1]['timestamp'])),
                    ];
                }
                else{

                    $boxpanne=false;
                    $formatted[] = [
                        'boxpanne' => $boxpanne,
                        'operation' => $operat,
                        'flot' => $result->getFlot()->getId(),
                        'box' => $result->getBox()->getImei(),
                        //'trams' => ($trams),
                        //'ctrams' => count($trams),
                        'id' => $result->getId(),
                        'type' => $result->getType(),
                        'nom' => $result->getLibele(),
                        'positionx' => $result->getPositionx(),
                        'positiony' => $result->getPositiony(),
                        'timestamp' => "Non identifier",
                        'date' => "Non identifier",
                        'time' => "Non identifier",
                    ];

                }
            }
        }
        //die();

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
                $image = $this->get('doctrine_mongodb')->getRepository
                ('ApiGpsAdministrationBundle:Mark')->findOneBy(array("image"=>$result->getName()));
                $nameimage=$image->getImage();
                if(count($trams)>0) {
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'image' => $nameimage,
                        'alert' => "eeee",
                        'panne' => $result->getPanne(),
                        //'alert' => count($result->getAlters()),
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
                        'timestamp' => $result->getTimestamp(),
                        'technical_visit' => date('Y-m-d', $result->getTechnicalVisit()->sec),
                        'insurance' => date('Y-m-d', $result->getInsurance()->sec),
                        'vignettes' => date('Y-m-d', $result->getVignettes()->sec),
                        'lastposition' => $trams[count($trams) - 1]['street'],
                    ];
                }
                else{
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'image' => $nameimage,
                        //'alert' => count($result->getAlters()),
                        'alert' => 'eeeee',
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
                'panne' => $result->getPanne(),
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
        //$panne = $request->get('panne');
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
        $data->setPanne(false);
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
        $idmark = $request->get('mark');
        $panne = $request->get('panne');
        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $idmodele =  $request->get('model');
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
            $vehicule->setFlot($vehicule->getFlot());
            if(!empty($boitier))
                $vehicule->setBox($boitier);
            if($panne=='true')
                $vehicule->setPanne(true);
            else
                $vehicule->setPanne(false);
            $vehicule->setType($type);
            $vehicule->setVidengetime($videngetime);
            $vehicule->setVidengekm($videngekm);
            $vehicule->setPuissance($puissance);
            $vehicule->setReservoir($reservoir);
            $vehicule->setRpmMax($rpmMax);
            $vehicule->setFuelType($typeCarburant);
                $vehicule->setMark($idmark);
                $vehicule->setModel($idmodele);
            //$sn->merge($vehicule);
        //var_dump($vehicule->getModel());die();
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
        /*$matricule = $request->get('reg_number');
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

        $mark = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Mark')->find($idmark);
        $model = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Model')->find($idmodele);*/
        $idfleet = $request->get('idfleet');
        $vehicule = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($id);
        $vehicule = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($id);
        if (empty($vehicule)) {
            return new View("Vehicle not found", Response::HTTP_NOT_ACCEPTABLE);
        }


        // elseif(!empty($matricule) && !empty($idBoitier)&& !empty($type)){
        /*$vehicule->setTechnicalVisit($technical_visit);
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
        $vehicule->setModel($model);*/
        //$sn->flush();
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
        //var_dump("aaaa");die();
        $userID=$request->get('id');
        /*$user=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($userID);*/
        $datemin=$request->get('datemin');
        $datemax=$request->get('datemax');


        /*$allvehicle=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();*/
        $allvehicle=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findOneBy(array('reg_number'=>$userID));
        $result= [];
        $resTrame=array();
        $c=0;

        //for($i=0;$i<count($allvehicle);$i++) {

            unset($resTrame);
            if ((!empty($allvehicle->getBox()) || $allvehicle->getBox() != null)
                ) {
                // $trames = $allvehicle[$i]->getBox()->getTrame();
                unset($trames);
                $trames = $this->idBoxtrames($allvehicle->getBox());
                foreach ($trames as $user) {


                    if (date('Y-m-d', strtotime($user["timestamp"])) <= $datemax &&
                        date('Y-m-d', strtotime($user["timestamp"])) >= $datemin) {

                        $resTrame[$c] = $user;
                        $c++;
                    }
                }
                //var_dump(count($resTrame));
            }
            /*var_dump($allvehicle[$i]->getRegNumber());
                die();*/

            unset($result);
            for ($j = 0; $j < count($resTrame); $j++) {
                $result[] = [
                    //'reg_number' => $allvehicle[$i]->getRegNumber(),
                    //'adress' => $obj->display_name,
                    'adress' => $resTrame[$j]["street"],
                    'timestamp' => date('Y-m-d H:i:s', $resTrame[$j]["timestamp"]),
                    'date' => date('Y-m-d H:i:s', $resTrame[$j]["timestamp"]),
                    'longitude' => $resTrame[$j]["longitude"],
                    'latitude' => $resTrame[$j]["latitude"],
                    'speed' => $resTrame[$j]["speed"],
                    'contact' => $resTrame[$j]["contact"],
                ];

            }
            if(empty($allvehicle->getMark())){
                $allvehicle->setMark("mercedes");
            }
            if(empty($allvehicle->getModel())){
                $allvehicle->setModel("Benz");
            }
            if (count($result )> 0) {
                $result1 = [
                    'reg_number' => $allvehicle->getRegNumber(),
                    'mark' => $allvehicle->getMark(),
                    'model' => $allvehicle->getModel(),
                    //'adress' => $obj->display_name,
                    'trams' => ($result),
                ];
            }

        //}
        //die();
        if(count($result1)>0)
            return $result1;
        else
            return null;

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
