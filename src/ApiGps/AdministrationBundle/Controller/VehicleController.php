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
        //var_dump($user);die();

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
        foreach ($results as $result) {
            $formatted[] = [
                'reg_number' => $result->getRegNumber(),
                'type_carburant' => $result->getFuelType(),
                'reservoir' => $result->getReservoir(),
                'id' => $result->getId(),
                'type' => $result->getType(),
                'mark' => $result->getMark(),
                'model' => $result->getModel(),
                'fuel_type' => $result->getFuelType(),
                'puissance' => $result->getPuissance(),
                'rpmMax' => $result->getRpmMax(),
                'technical_visit' => date('Y-m-d',$result->getTechnicalVisit()->sec),
                'insurance' => date('Y-m-d',$result->getInsurance()->sec),
                'vignettes' => date('Y-m-d',$result->getVignettes()->sec),
            ];
        }
        return $formatted;
    }
    /**
     * @Rest\Get("/myunicrpm/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmyrpmunicAction(Request $request)
    {
        $id = $request->get('id');
        $dtu1=array();
        $dtu=array();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
        for ( $c=0;$c< count($results);$c++) {

                array_push($dtu1,  $results[$c]->getRpmMax());

        }
       // var_dump($dtu1);die();
        $dtu=array_unique($dtu1);
        $ss=array_merge($dtu);
        return $ss;
    }
    /**
     * @Rest\Get("/myunicmark/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmymarkAction(Request $request)
    {
        $id = $request->get('id');
        $dtu1=array();
        $dtu=array();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
        for ( $c=0;$c< count($results);$c++) {

            array_push($dtu1,  $results[$c]->getMark());

        }
        // var_dump($dtu1);die();
        $dtu=array_unique($dtu1);
        $ss=array_merge($dtu);
        return $ss;
    }
    /**
     * @Rest\Get("/myunicmodel/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmymodelAction(Request $request)
    {
        $id = $request->get('id');
        $dtu1=array();
        $dtu=array();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
        for ( $c=0;$c< count($results);$c++) {

            array_push($dtu1,  $results[$c]->getModel());

        }
        // var_dump($dtu1);die();
        $dtu=array_unique($dtu1);
        $ss=array_merge($dtu);
        return $ss;
    }
    /**
     * @Rest\Get("/myunitype/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmytypeAction(Request $request)
    {
        $id = $request->get('id');
        $dtu1=array();
        $dtu=array();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
        for ( $c=0;$c< count($results);$c++) {

            array_push($dtu1,  $results[$c]->getType());

        }
        // var_dump($dtu1);die();
        $dtu=array_unique($dtu1);
        $ss=array_merge($dtu);
        return $ss;
    }
    /**
     * @Rest\Get("/myunicpuissance/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmypuissanceAction(Request $request)
    {
        $id = $request->get('id');
        $dtu1=array();
        $dtu=array();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
        for ( $c=0;$c< count($results);$c++) {

            array_push($dtu1,  $results[$c]->getPuissance());

        }
        // var_dump($dtu1);die();
        $dtu=array_unique($dtu1);
        $ss=array_merge($dtu);
        return $ss;
    }
    /**
     * @Rest\Get("/myunicreservoir/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmyreservoirAction(Request $request)
    {
        $id = $request->get('id');
        $dtu1=array();
        $dtu=array();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
        for ( $c=0;$c< count($results);$c++) {

            array_push($dtu1,  $results[$c]->getReservoir());

        }
        // var_dump($dtu1);die();
        $dtu=array_unique($dtu1);
        $ss=array_merge($dtu);
        return $ss;
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
     * @Rest\Get("/myflot/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmyvehiculeAction(Request $request)
    {
        $id = $request->get('id');
        $dtu1=array();
        $dtu=array();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company' => $user->getCompany()));
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
        $matricule = $request->get('reg_number');
        $type = $request->get('type');
        $reservoir = $request->get('reservoir');
        $typeCarburant = $request->get('type_carburant');
        $idmark = $request->get('idmark');
        $idfleet = $request->get('idfleet');
        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $idBoitier = $request->get('box');
        $insurance = $request->get('insurance');
        $vignettes = $request->get('vignettes');
        $technical_visit = $request->get('technical_visit');
        $idmodele =  $request->get('idmodel');
        $mark = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Mark')->find($idmark);
        $model = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Model')->find($idmodele);
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idBoitier);
        $fleet = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->find($idfleet);
        //dump($fleet);die();

        //var_dump($boitier);die();
        if(empty($matricule)|| empty($type))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setInsurance($insurance);
        $data->setVignettes($vignettes);
        $data->setTechnicalVisit($technical_visit);
        $data->setFlot($fleet);
        $data->setRegNumber($matricule);
        $data->setBox($boitier);
        $data->setType($type);
        $data->setPuissance($puissance);
        $data->setReservoir($reservoir);
        $data->setRpmMax($rpmMax);
        $data->setFuelType($typeCarburant);
        $data->setMark($mark);
        $data->setModel($model);

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
        $idmark = $request->get('idmark');
        $idfleet = $request->get('idfleet');
        $puissance = $request->get('puissance');
        $rpmMax = $request->get('rpmMax');
        $technical_visit = $request->get('technical_visit');
        $idmodele =  $request->get('idmodel');
        $insurance = $request->get('insurance');
        $vignettes = $request->get('vignettes');
        $idBoitier = $request->get('box');
        $fleet = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->find($idfleet);
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idBoitier);
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
            $vehicule->setFlot($fleet);
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
        //$user = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:User')->findById($userID);
        //$allvehicle=$user->getCompany()->getVehicles();
        $userID=$request->get('id');
        $datemin=$request->get('datemin');
        $datemax=$request->get('datemax');
        //$allvehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->findAll();
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($userID);
        $allvehicle=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company'=>$user->getCompany()));;

        $result= [];
        $resTrame=array();
        $c=0;
        for($i=0;$i<count($allvehicle);$i++){
            $trames=$allvehicle[$i]->getBox()->getTrame();
            for ($j=0;$j<count($trames);$j++){
                //$time= Date("d-m-Y",$trames[$j]->getTimestamp()); $trames[$j]->getTimestamp()
                //date('Y-m-d',$result[$i]->getBox()->getTrame()[$j]->getTimestamp())
                if((date('Y-m-d',$trames[$j]->getTimestamp()) > $datemin) &&
                    (date('Y-m-d',$trames[$j]->getTimestamp())< $datemax) ){
                    $resTrame[$c]=$trames[$j];
                    $c++;
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
