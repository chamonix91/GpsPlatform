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
     * @Rest\Get("/trame")
     */
    public function getTrameAction()
    {
        $trame = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')->findAll();
        if ($trame === null) {
            return new View("no trame found", Response::HTTP_NOT_FOUND);
        }
        return $trame;
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
     * @Rest\Post("/trame")
     * @param Request $request
     * @return string
     */
    public function postTrameAction(Request $request)
    {
        $data = new Trame();
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

        if(empty($speed) || empty($altitude)|| empty($longitude)|| empty($latitude))
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
        $data->setExternalvoltage($externalvoltage);
        $data->setBox($box);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("Trame Added Successfully", Response::HTTP_OK);
    }

    public function getCarburant ()
    {


    }
}
