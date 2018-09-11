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
            if($tab[$i]['date']==$d && $tab[$i]['contact']==1 ){
                return $i;
            }
        }
        return null;
    }
    public function lastocurencedate($tab,$d){
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['date']==$d &&  $tab[$i]['contact']==1){
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
            ->findAll();
        for($i=0;$i<count($result);$i++) {
            $trame = array();
            $tramef = array();
            $tramef1 = array();
            $tramef2 = array();
            $rap = array();
            $dt = array();
            $dt1 = array();
            $dt2 = array();
            $indt = array();
            $indt1 = array();
            $indt2 = array();
        if(!empty($result[$i]->getBox())){
            for ($j = 0; $j < count($result[$i]->getBox()->getTrame()); $j++) {
                $s = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" . $result[$i]->getBox()->getTrame()[$j]->getLatitude()
                    . "&lon=" . $result[$i]->getBox()->getTrame()[$j]->getLongitude() . "&accept-language=fr";
                $options = array(
                    "http" => array(
                        "header" => "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
                    )
                );
                $context = stream_context_create($options);
                $resultj = file_get_contents($s, true, $context);
                $obj = json_decode($resultj);
                $trame[] = [
                    'id' => $result[$i]->getBox()->getTrame()[$j]->getId(),
                    'adress' => $obj->display_name,
                    'time' => date('Y-m-d H:i:s', $result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                    'date' => date('Y-m-d', $result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                    'timestamp' => $result[$i]->getBox()->getTrame()[$j]->getTimestamp(),
                    'contact' => $result[$i]->getBox()->getTrame()[$j]->getContact(),
                    'speed' => $result[$i]->getBox()->getTrame()[$j]->getSpeed(),
                ];
            }
        }
            $vitesse=0;
            for($c=0;$c<count($trame);$c++){
                $vitesse=$vitesse+$trame[$c]['speed'];
                array_push($dt,str_replace(' ', '', date('Y-m-d ',$trame[$c]['timestamp'])));
                array_push($dt1,$trame[$c]['adress']);
            }
            $dtu=array_unique($dt);
            $ss=array_merge($dtu);
            $dtu1=array_unique($dt1);
            $ss1=array_merge($dtu1);
            $work=array();
            for($f=0;$f<count($ss);$f++){
                array_push($indt,$this->firstocurencedate($trame,$ss[$f]));
                array_push($indt,$this->lastocurencedate($trame,$ss[$f]));
            }
            for($c=0;$c<count($indt);$c++){
                array_push($tramef,$trame[$indt[$c]]);
            }

            for($f=0;$f<count($ss1);$f++){
                array_push($indt1,$this->firstocurencestreet($trame,$ss1[$f]));
                array_push($indt1,$this->lastocurencestreet($trame,$ss1[$f]));
                if($this->firstocurencestreetoff($trame,$ss1[$f]) >-1 &&
                    $this->lastocurencestreetoff($trame,$ss1[$f]) >-1 ) {
                    array_push($indt2, $this->firstocurencestreetoff($trame, $ss1[$f]));
                    array_push($indt2, $this->lastocurencestreetoff($trame, $ss1[$f]));
                }
            }

            for($c=0;$c<count($indt1);$c++){
                array_push($tramef1,$trame[$indt1[$c]]);
            }
            for($c=0;$c<count($indt2);$c++){
                array_push($tramef2,$trame[$indt2[$c]]);
            }
            $p1=0;/****/
            for($c=0;$c<count($tramef1);$c++){
                if($c % 2 ==0){
                    $rap1[] = [
                        'adress' => $tramef1[$c]['adress'],
                        'time' => $tramef1[$c]['time'],
                        'date' => $tramef1[$c]['date'],
                        'adress1' => $tramef1[$c+1]['adress'],
                        'time1' => $tramef1[$c+1]['time'],
                        'date1' => $tramef1[$c+1]['date'],
                        'speed' => intval(($tramef1[$c]['speed']+$tramef1[$c+1]['speed'])/2),
                        'pause' => date('H:i:s',$tramef1[$c+1]['timestamp'] - $tramef1[$c]['timestamp']),

                    ];
                   // $p1=$p1+($tramef1[$c+1]['timestamp'] - $tramef1[$c]['timestamp']);

                }


            }
           // var_dump(date('H:i:s',$p1));
            for($c=0;$c<count($tramef2);$c++){
                if($c % 2 ==0){
                    $rap2[] = [
                        'adress' => $tramef2[$c]['adress'],
                        'time' => $tramef2[$c]['time'],
                        'date' => $tramef2[$c]['date'],
                        'adress1' => $tramef2[$c+1]['adress'],
                        'pause' => date('H:i:s',$tramef2[$c+1]['timestamp'] - $tramef2[$c]['timestamp']),
                        'time1' => $tramef2[$c+1]['time'],
                        'date1' => $tramef2[$c+1]['date'],
                        'speed' => intval(($tramef2[$c]['speed']+$tramef2[$c+1]['speed'])/2),
                    ];
                }
            }


            /****/
            for($c=0;$c<count($tramef);$c++){

                if($c % 2 ==0){
                    $s=  array();
                    //var_dump(count($s));
                    for($q=0;$q<count($rap2);$q++){
                        if($tramef[$c]['adress']==$rap2[$q]['adress'] &&
                            $tramef[$c]['date']==$rap2[$q]['date']){
                            array_push($s,$rap2[$q]['pause']);
                        }
                    }
                    if(count($s)>0) {
                        $rap[] = [
                            'ye5dem' => date('H:i:s',($tramef[$c+1]['timestamp'] - $tramef[$c]['timestamp'])
                                -strtotime($this->AddPlayTime($s))) ,
                            'wegef' => $this->AddPlayTime($s),
                            'adress' => $tramef[$c]['adress'],
                            'time' => $tramef[$c]['time'],
                            'date' => $tramef[$c]['date'],
                            'adress1' => $tramef[$c + 1]['adress'],
                            'time1' => $tramef[$c + 1]['time'],
                            'date1' => $tramef[$c + 1]['date'],
                            'speed' => intval(($tramef[$c]['speed'] + $tramef[$c + 1]['speed']) / 2),
                        ];
                    }
                    else{
                        $rap[] = [
                            'ye5dem' => date('H:i:s',$tramef[$c+1]['timestamp'] - $tramef[$c]['timestamp']),
                            'wegef' => '00:00:00',
                            'adress' => $tramef[$c]['adress'],
                            'time' => $tramef[$c]['time'],
                            'date' => $tramef[$c]['date'],
                            'adress1' => $tramef[$c + 1]['adress'],
                            'time1' => $tramef[$c + 1]['time'],
                            'date1' => $tramef[$c + 1]['date'],
                            'speed' => intval(($tramef[$c]['speed'] + $tramef[$c + 1]['speed']) / 2),
                        ];
                    }
                }
            }

            if(count($trame)==0) {
                $lcp[] = [
                    'reg_number' => $result[$i]->getRegNumber(),
                    'mark' => $result[$i]->getMark(),
                    'type' => $result[$i]->getType(),
                    'model' => $result[$i]->getModel(),
                    'speed' => 0,
                    'trame' => $rap,
                ];
            }else{
                $lcp[] = [
                    'reg_number' => $result[$i]->getRegNumber(),
                    'mark' => $result[$i]->getMark(),
                    'type' => $result[$i]->getType(),
                    'model' => $result[$i]->getModel(),
                    'speed' => intval($vitesse / count($trame)),
                    'trame' => $rap,
                ];
            }
        }
       // die();
           return $lcp;
    }
    function AddPlayTime($times) {
        $minutes = 0; //declare minutes either it gives Notice: Undefined variable
        // loop throught all the times
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }
    /**
     * @Rest\Get("/streeton/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmyVehicleStreetTraficAction(Request $request)
    {

        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();
        for($i=0;$i<count($result);$i++){
            $trame=array();
            $tramef=array();
            $rap=array();
            $dt=array();
            $indt=array();
            if(!empty($result[$i]->getBox())) {
                for ($j = 0; $j < count($result[$i]->getBox()->getTrame()); $j++) {
                    $s = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" . $result[$i]->getBox()->getTrame()[$j]->getLatitude()
                        . "&lon=" . $result[$i]->getBox()->getTrame()[$j]->getLongitude() . "&accept-language=fr";

                    /* $json = file_get_contents($s);
                     $obj = json_decode($json);
                     var_dump($obj);die();*/

                    $options = array(
                        "http" => array(
                            "header" => "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
                        )
                    );

                    $context = stream_context_create($options);
                    $resultj = file_get_contents($s, true, $context);
                    $obj = json_decode($resultj);
                    $trame[] = [
                        'id' => $result[$i]->getBox()->getTrame()[$j]->getId(),
                        'adress' => $obj->display_name,
                        'time' => date('Y-m-d H:i:s', $result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                        'date' => date('Y-m-d', $result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                        'timestamp' => $result[$i]->getBox()->getTrame()[$j]->getTimestamp(),
                        'contact' => $result[$i]->getBox()->getTrame()[$j]->getContact(),
                        'speed' => $result[$i]->getBox()->getTrame()[$j]->getSpeed(),
                    ];
                }
            }//var_dump($trame);die();
            $vitesse=0;
            for($c=0;$c<count($trame);$c++){
                $vitesse=$vitesse+$trame[$c]['speed'];
                array_push($dt,$trame[$c]['adress']);
            }
            $dtu=array_unique($dt);
            $ss=array_merge($dtu);
            for($f=0;$f<count($ss);$f++){
                array_push($indt,$this->firstocurencestreet($trame,$ss[$f]));
                array_push($indt,$this->lastocurencestreet($trame,$ss[$f]));
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
                    'type' => $result[$i]->getType(),
                    'speed' => 0,
                    'trame' => $rap,
                ];
            }else{
                $lcp[] = [
                    'reg_number' => $result[$i]->getRegNumber(),
                    'mark' => $result[$i]->getMark(),
                    'model' => $result[$i]->getModel(),
                    'type' => $result[$i]->getType(),
                    'speed' => intval($vitesse / count($trame)),
                    'trame' => $rap,
                ];
            }

        }
        return $lcp;

    }
    public function onstreet($tab,$i,$j){
        $s=0;
        for($c=$i;$c<=$j;$c++){
            $s=$s+$tab[$i]['timestamp'];
        }
        return $s;
    }
    public function firstocurencestreet($tab,$d){
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['adress']==$d && $tab[$i]['contact']==1 ){
                return $i;
            }
        }
        return null;
    }
    public function lastocurencestreet($tab,$d){
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['adress']==$d &&  $tab[$i]['contact']==1){
                $ind= $i;
            }
        }
        return $ind;
    }
    public function firstocurencestreetoff($tab,$d){
        $ind=-1;
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['adress']==$d && $tab[$i]['contact']==0 ){
                return $i;
            }
        }
        return null;
    }
    public function lastocurencestreetoff($tab,$d){
        $ind=-1;
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['adress']==$d &&  $tab[$i]['contact']==0){
                $ind= $i;
            }
        }
        return $ind;
    }
    /**
     * @Rest\Get("/streetoff/{id}",name="hfgfh")
     * @param Request $request
     * @return view
     */
    public function getmyVehicleStreetTraficoffAction(Request $request)
    {

        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();
        for($i=0;$i<count($result);$i++) {
            $trame = array();
            $tramef = array();
            $rap = array();
            $dt = array();
            $indt = array();
            if(!empty($result[$i]->getBox())){
            for ($j = 0; $j < count($result[$i]->getBox()->getTrame()); $j++) {
                $s = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" . $result[$i]->getBox()->getTrame()[$j]->getLatitude()
                    . "&lon=" . $result[$i]->getBox()->getTrame()[$j]->getLongitude() . "&accept-language=fr";

                /* $json = file_get_contents($s);
                 $obj = json_decode($json);
                 var_dump($obj);die();*/

                $options = array(
                    "http" => array(
                        "header" => "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
                    )
                );

                $context = stream_context_create($options);
                $resultj = file_get_contents($s, true, $context);
                $obj = json_decode($resultj);
                $trame[] = [
                    'id' => $result[$i]->getBox()->getTrame()[$j]->getId(),
                    'adress' => $obj->display_name,
                    'time' => date('Y-m-d H:i:s', $result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                    'timee' => date('H:i:s', $result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                    'date' => date('Y-m-d', $result[$i]->getBox()->getTrame()[$j]->getTimestamp()),
                    'timestamp' => $result[$i]->getBox()->getTrame()[$j]->getTimestamp(),
                    'contact' => $result[$i]->getBox()->getTrame()[$j]->getContact(),
                    'speed' => $result[$i]->getBox()->getTrame()[$j]->getSpeed(),
                ];
            }
        }//var_dump($trame);die();
            for($c=0;$c<count($trame);$c++){
                array_push($dt,$trame[$c]['adress']);
            }
            $dtu=array_unique($dt);
            $ss=array_merge($dtu);
            for($f=0;$f<count($ss);$f++){
                if($this->firstocurencestreetoff($trame,$ss[$f]) >-1 &&
               $this->lastocurencestreetoff($trame,$ss[$f]) >-1 ) {
                    array_push($indt, $this->firstocurencestreetoff($trame, $ss[$f]));
                    array_push($indt, $this->lastocurencestreetoff($trame, $ss[$f]));
                }
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
                        'pause' => date('H:i:s',$tramef[$c+1]['timestamp'] - $tramef[$c]['timestamp']),
                        'time1' => $tramef[$c+1]['time'],
                        'date1' => $tramef[$c+1]['date'],
                        'speed' => intval(($tramef[$c]['speed']+$tramef[$c+1]['speed'])/2),
                    ];
                }
            }

            $lcp[] = [
                'reg_number' => $result[$i]->getRegNumber(),
                'mark' => $result[$i]->getMark(),
                'type' => $result[$i]->getType(),
                'model' => $result[$i]->getModel(),
                'type' => $result[$i]->getType(),
                'trame' => $rap,
            ];

        }
        return $lcp;

    }

}
