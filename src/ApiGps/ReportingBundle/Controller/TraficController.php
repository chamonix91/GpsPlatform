<?php

namespace ApiGps\ReportingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
class TraficController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function firstocurencedate($tab,$d){
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['date']==$d){
                return $i;
            }
        }
        return null;
    }
    public function lastocurencedate($tab,$d){
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['date']==$d){
                $ind= $i;
            }
        }
        return $ind;
    }
    /**
     * @Rest\Get("/traf/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmyVehicleTraficAction(Request $request)
    {

        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findBy(array('company'=>$user->getCompany()));


       // var_dump($obj->results[0]->formatted_address);die();
        for($i=0;$i<count($result);$i++){
            $trame=array();
            $tramef=array();
            $rap=array();
            $dt=array();
            $indt=array();
            for($j=0;$j<count($result[$i]->getBox()->getTrame());$j++){
                $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$result[$i]->getBox()->getTrame()[$j]->getLatitude().','.$result[$i]->getBox()->getTrame()[$j]->getLongitude().'&key=AIzaSyB60tFTkffoU_RGsBES2oUH01gAsHW0-0g');
                $obj = json_decode($json);
                $trame[] = [
                    'id' => $result[$i]->getBox()->getTrame()[$j]->getId(),
                    'adress' => $obj->results[0]->formatted_address,
                    'time' => date('Y-m-d H:i:s',$result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                    'date' => date('Y-m-d',$result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                    'timestamp' => $result[$i]->getBox()->getTrame()[$j]->getTimestamp(),
                    'contact' => $result[$i]->getBox()->getTrame()[$j]->getContact(),
                    'speed' => $result[$i]->getBox()->getTrame()[$j]->getSpeed(),
                ];

            }
            //var_dump($trame);
            $vitesse=0;
            for($c=0;$c<count($trame);$c++){
                $vitesse=$vitesse+$trame[$c]['speed'];
                array_push($dt,str_replace(' ', '', date('Y-m-d ',$trame[$c]['timestamp'])));
                //array_push($dt,date('Y-m-d ',strtotime($trame[$c]['time'])));
            }
            $dtu=array_unique($dt);
            $ss=array_merge($dtu);
            //var_dump($trame);die();
            for($f=0;$f<count($ss);$f++){
                array_push($indt,$this->firstocurencedate($trame,$ss[$f]));
                array_push($indt,$this->lastocurencedate($trame,$ss[$f]));
            }
            for($c=0;$c<count($indt);$c++){
                array_push($tramef,$trame[$indt[$c]]);
            }
            for($c=0;$c<count($tramef);$c++){
                if($c % 2 ==0){
                    $rap[] = [
                        'adress' => $tramef[$c]['adress'],
                        'time' => $tramef[$c]['time'],
                        'date' => $tramef[$c]['date'],
                        'adress1' => $tramef[$c+1]['adress'],
                        'time1' => $tramef[$c+1]['time'],
                        'date1' => $tramef[$c+1]['date'],
                        'speed' => intval(($tramef[$c]['speed']+$tramef[$c+1]['speed'])/2),
                    ];
                }
            }
            if(count($trame)==0) {
                $lcp[] = [
                    'reg_number' => $result[$i]->getRegNumber(),
                    'mark' => $result[$i]->getMark(),
                    'model' => $result[$i]->getModel(),
                    'speed' => 0,
                    'trame' => $rap,
                ];
            }else{
                $lcp[] = [
                    'reg_number' => $result[$i]->getRegNumber(),
                    'mark' => $result[$i]->getMark(),
                    'model' => $result[$i]->getModel(),
                    'speed' => intval($vitesse / count($trame)),
                    'trame' => $rap,
                ];
            }
        }
           return $lcp;
    }
}
