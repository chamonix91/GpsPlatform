<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Trame;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class TrameController extends FOSRestController
{

    /**
     * @Rest\Get("/trame" , name="zomm")
     */
    public function getTrameAction()
    {
        //5be74a4413cf753d698b4567
        $trame = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->findAll();
        if ($trame === null) {
            return new View("no trame found", Response::HTTP_NOT_FOUND);
        }
        //var_dump(count($trame));die();
        foreach ($trame as $user) {

                //var_dump($user->getBox()->getTrame()[0]->getBox()->getId());die();
            if($user->getBox()!=null || !empty($user->getBox())){
                $formatted[] = [
                    'id' => $user->getId(),/*
                    'timestamp' => $user->getTimestamp(),
                    'longitude' => $user->getLongitude(),
                    'latitude' => $user->getLatitude(),
                    'angle' => $user->getAngle(),
                    'speed' => $user->getSpeed(),
                    'contact' => $user->getContact(),*/
                    'timestamp' => $user->getTimestamp(),
                    //'box' => $user->getBox()->getImei(),

                ];
            }


            }
        /*usort($formatted, function ($a, $b) {
            return $a['timestamp'] >= $b['timestamp'];
        });*/
        return count($formatted);
    }
    /**
     * @Rest\Get("/mytrame" , name="zomm")
     */
    public function getMyTrameAction()
    {
        //5be74a4413cf753d698b4567
        $trame = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->findAll();
        if ($trame === null) {
            return new View("no trame found", Response::HTTP_NOT_FOUND);
        }
        //var_dump(count($trame));die();
        foreach ($trame as $user) {

            var_dump($user->getBox()->getCompany()->getId());die();
            $formatted[] = [
                'id' => $user->getId(),
                'timestamp' => $user->getTimestamp(),
                'street' => $user->getStreet(),
                'longitude' => $user->getLongitude(),
                'latitude' => $user->getLatitude(),
                'angle' => $user->getAngle(),
                'speed' => $user->getSpeed(),
                'contact' => $user->getContact(),
                'box' => $user->getBox()->getImei(),

            ];

        }
        return ($formatted);
    }


    /**
     * @Rest\Get("/trame/{id}")
     * @param $id
     * @return Trame|View|null|object
     */
    public function GetTrameByIdAction($id)
    {
        $trame = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->find($id);

        if ($trame === null) {
            return new View("Trame dosen't exist", Response::HTTP_NOT_FOUND);
        }
        return $trame;
    }

    /**
     * @Rest\Post("/trame",name="addfrommsg")
     * @return string
     */
    public function postTrameAction(Request $request)
    {

        $data1 = json_decode($request->getContent(), true);
        $data = new Trame();


        $timestamp= $data1['timestamp'];
        $street= $data1['street'];
        $latitude= $data1['latitude'];
        $longitude= $data1['longitude'];
        $angle= $data1['angle'];
        $speed= $data1['speed'];
        $boxu= $data1['box'];
        $contact= $data1['contact'];
        $milage= $data1['kilo'];
        $din1= $data1['Din 1'];
        $ios= ($data1['ioelemtn']);



        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->findOneBy(array("imei"=>$boxu));

        //$box= $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($b);

        if(  empty($longitude))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setStreet($street);
        $data->setAngle($angle);
        $data->setLatitude($latitude);
        $data->setLongitude($longitude);
        $data->setContact($longitude);
        $data->setSpeed($speed);
        $data->setTotalMileage($milage);
        $data->setTimestamp($timestamp);
        $data->setBox($box);
        $data->setContact($contact);
        //$data->setContact(rand(0, 10) / 10);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("Trame Added Successfully", Response::HTTP_OK);
    }
    /**
     * @Rest\Put("/trame/{id}")
     * @param Request $request
     * @return string
     */
    public function putTrameAction(Request $request)
    {
       // $data = new Trame();
        $id= $request->get('id');
        var_dump($id);
        $data=$this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->find($id);
        //var_dump($data);die();
        $header= $request->get('header');
        $codecid= $request->get('codecid');
        $nbrdata= $request->get('nbrdata');
        $timestamp= $request->get('timestamp');
        $priority= $request->get('priority');
        $longitude= $request->get('longitude');
        $latitude= $request->get('latitude');
        $altitude= $request->get('altitude');
        $angle= $request->get('angle');
        $sat= $request->get('sat');
        $speed= $request->get('speed');
        $fuelConsumed= $request->get('fuelconsumed');
        $fuelLvl= $request->get('fuelLvl');
        $engineRpm= $request->get('enginerpm');
        $fuelLvlp= $request->get('fuelLvlp');
        $engineworktime= $request->get('engineworktime');
        $engineworktimecounted= $request->get('engineworktimecounted');
        $engineload= $request->get('engineload');
        $enginetemperature= $request->get('enginetemperature');
        $batterielvl= $request->get('batterielvl');
        $batterietemperature= $request->get('batterietemperature');
        $totalmil= $request->get('totalmil');
        $totalmilc= $request->get('totalmilc');
        $contact= $request->get('contact');
        $externalvoltage= $request->get('externalvoltage');

        $b= $request->get('box');

        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($b);

        //$box= $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($b);

        /*if(empty($speed) || empty($altitude)|| empty($longitude)|| empty($latitude))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setAltitude($altitude);
        $data->setAngle($angle);
        $data->setHeader($header);
        $data->setCodecid($codecid);
        $data->setLatitude($latitude);
        $data->setLongitude($longitude);
        $data->setNbrdata($nbrdata);
        $data->setPriority($priority);
        $data->setSat($sat);
        $data->setSpeed($speed);
        $data->setTimestamp($timestamp);
        $data->setFeelConsumed($fuelConsumed);
        $data->setFeelLvl($fuelLvl);
        $data->setFeelLvlp($fuelLvlp);
        $data->setEngineRpm($engineRpm);
        $data->setEngineload($engineload);
        $data->setEnginetempirature($enginetemperature);
        $data->setEngineworktime($engineworktime);
        $data->setEngineworktimecounted($engineworktimecounted);
        $data->setBatrieLvl($batterielvl);
        $data->setBatrietempirature($batterietemperature);
        $data->setTotalMileage($totalmil);
        $data->setTotalMileagec($totalmilc);
        $data->setContact($contact);
        $data->setExternalvoltage($externalvoltage);*/
        $data->setBox($box);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("Trame Added Successfully", Response::HTTP_OK);
    }


}
