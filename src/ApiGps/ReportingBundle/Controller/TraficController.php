<?php

namespace ApiGps\ReportingBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Constraints\Time;


class TraficController extends FOSRestController
{
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
     * @return array
     */
    public function getmyVehicleTraficAction(Request $request)
    {
        $id = $request->get('id');
        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);


        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();


        $lcp=array();
        foreach ($result as $vehi) {

            $firstlastted = array();
            $formatted[] = array();
            $dates = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {
                $trams = $this->idBoxtrames($vehi->getBox());
                if(count($trams)>0){
                foreach ($trams as $user) {

                    // if ($user->getBox()->getCompany()->getId() == $user1->getCompany()->getId()) {

                    array_push($dates, date('Y-m-d', strtotime($user["timestamp"])));
                    array_push($valorate, $user);

                    $formatted[] = [
                        'id' => $user["id"],
                        //'adress' => $obj->display_name,
                        'adress' => $user["street"],
                        'timestamp' => $user["timestamp"],
                        'street' => $user["street"],
                        'time' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                        'date' => date('Y-m-d', strtotime($user["timestamp"])),
                        'longitude' => $user["longitude"],
                        'latitude' => $user["latitude"],
                        'angle' => $user["angle"],
                        'speed' => $user["speed"],
                        'contact' => $user["contact"],
                        'box' => $user["box"],

                    ];
                    //}
                }
                }
            }
            $k = 0;
            $ss = array_values(array_unique($dates, true));

            $ss1 = array_reverse($ss, true);
            foreach ($ss1 as $uniqdate) {
                //for ($k=130;$k<$val;$k++) {
                //var_dump($uniqdate);
                $first = array_search($uniqdate, $dates); // 0
                $last = array_search($ss1[$k], $dates);
                $k++;
                $firstlastted[] = [
                    'first' => $first,
                    'last' => (count($dates) - 1) - $last,
                ];
            }
            //var_dump(count($firstlastted));
            $ui=0;
            foreach ($firstlastted as $fl) {
                /*$s = "http://51.75.124.43:89/nominatim/reverse?format=jsonv2&lat=" . $valorate[$fl['first']]["latitude"]
                    . "&lon=" . $valorate[$fl['first']]["longitude"] . "&accept-language=fr";
                $s1 = "http://51.75.124.43:89/nominatim/reverse?format=jsonv2&lat=" . $valorate[$fl['last']]["latitude"]
                    . "&lon=" . $valorate[$fl['last']]["longitude"] . "&accept-language=fr";
                $options = array(
                    "http" => array(
                        "header" => "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
                    )
                );

                $context = stream_context_create($options);
                $resultj = file_get_contents($s, true, $context);
                $obj = json_decode($resultj);
                $resultj1 = file_get_contents($s1, true, $context);
                $obj1 = json_decode($resultj1);*/
                $vit=0;
                $vit=$vit+intval(($valorate[$fl['last']]['speed'] + $valorate[$fl['first']]['speed']) / 2);
                $rap[] = [//'adress' => $user["street"],
                    'adress' => $valorate[$fl['first']]["street"],
                    'time' => date('Y-m-d H:i:s', strtotime($valorate[$fl['first']]["timestamp"])),
                     'date' => date('Y-m-d', strtotime($valorate[$fl['first']]["timestamp"])),
                     'adress1' => $valorate[$fl['last']]["street"],
                     'time1' => date('Y-m-d H:i:s', strtotime($valorate[$fl['last']]["timestamp"])),
                     'date1' => date('Y-m-d', strtotime($valorate[$fl['last']]["timestamp"])),
                     'speed' => intval(($valorate[$fl['last']]['speed'] + $valorate[$fl['first']]['speed']) / 2),
                ];
               // var_dump($rap);
                $lcp[] = [
                    'reg_number' => $vehi->getRegNumber(),
                    'mark' => $vehi->getMark(),
                    'type' => $vehi->getType(),
                    'model' => $vehi->getModel(),
                    'speed' => $vit / count($rap),
                    'trame' => $rap,
                ];
                $ui++;

            }



        }
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
    public function idBoxtrames($id)
    {

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')
            ->findBy(array('box' => $id));
        if ($result === null) {
            return null;
        }
        //$a = array_unique(($result));

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
            }

            $formatted[] = [
                'id' => $user->getId(),
                'timestamp' => $az,
                'street' => $user->getStreet(),
                'longitude' => $user->getLongitude(),
                'latitude' => $user->getLatitude(),
                'angle' => $user->getAngle(),
                'speed' => $user->getSpeed(),
                'contact' => $user->getContact(),
                'box' => $user->getBox()->getImei(),
                'kilo' => $user->getTotalMileage(),
                'milage' => $user->getTotalMileage(),

            ];
        }
        usort($formatted, function ($a, $b) {
            return $a['timestamp'] >= $b['timestamp'];
        });

       // var_dump($a);die();
        if(count($result)>0)
        return $formatted;
        else
            return null;
    }
    public function idBoxtramesfuel($id)
    {

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')
            ->findBy(array('box' => $id));
        if ($result === null) {
            return null;
        }
        foreach ($result as $user) {
           // if($user->getFeelLvl() != "Non supporté" && $user->getFeelConsumed()!="Non supporté") {
                $formatted[] = [
                    'id' => $user->getId(),
                    'timestamp' => $user->getTimestamp(),
                    'street' => $user->getStreet(),
                    'longitude' => $user->getLongitude(),
                    'latitude' => $user->getLatitude(),
                    'angle' => $user->getAngle(),
                    'speed' => $user->getSpeed(),
                    'contact' => $user->getContact(),
                    'tfu' => $user->getFeelConsumed(),
                    'tfl' => $user->getFeelLvl(),
                    'box' => $user->getBox()->getImei(),

                ];
            }
       // }
        if(count($result)>0)
            return $formatted;
        else
            return null;
    }
    public function getmyvehi($id){

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
                $trams=$this->idBoxtrames($result->getBox());

                //var_dump([count($trams)]->getId());die();

                $formatted[] = [
                    'reg_number' => $result->getRegNumber(),
                    'flot' => $result->getFlot()->getId(),
                    'box' => $result->getBox()->getImei(),
                    'trams'=>($trams),
                    'ctrams'=>count($trams),
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
                ];
            }
        }

        return ($formatted);
    }
    function objectToArray ($object) {
        if(!is_object($object) && !is_array($object))
            return $object;

        return array_map('objectToArray', (array) $object);
    }
    /**
     * @Rest\Get("/streeton/{id}",name="hfgfh")
     * @param Request $request
     * @return array
     */
    public function getmyVehicleStreetTraficAction(Request $request)
    {
        $id = $request->get('id');
        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);


        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();



        $lcp=array();
        foreach ($result as $vehi) {

            $firstlastted = array();
            $formatted[] = array();
            $dates = array();
            $streets = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {
                $trams = $this->idBoxtrames($vehi->getBox());
                //var_dump($trams);die();
                if(count($trams)>0){
                foreach ($trams as $user) {
                    if($user["contact"]==1){

                    /*array_push($dates, date('Y-m-d', $user["timestamp"]));*/
                    array_push($valorate, $user);
                    //var_dump($user["street"]);die();
                   array_push($streets, $user["street"]);

                    $formatted[] = [
                        'id' => $user["id"],
                        'adress' => $user["street"],
                        'timestamp' => $user["timestamp"],
                        'time' => date('Y-m-d H:i:s', $user["timestamp"]),
                        'date' => date('Y-m-d', $user["timestamp"]),
                        'longitude' => $user["longitude"],
                        'latitude' => $user["latitude"],
                        'angle' => $user["angle"],
                        'speed' => $user["speed"],
                        'contact' => $user["contact"],
                        'box' => $user["box"],

                    ];
                    //}
                }
                }

            }
            }
            $k = 0;
            //var_dump(array_unique($streets ));
            $ss = array_values(array_unique($streets));
            $ss1 = array_reverse($ss, true);
            foreach ($ss1 as $uniqdate) {
                //for ($k=130;$k<$val;$k++) {
                //var_dump($uniqdate);
                $first = array_search($uniqdate, $streets); // 0
               // var_dump($first);die();
                $last = array_search($ss1[$k], $streets);
                $k++;
                $firstlastted[] = [
                    'first' => $first,
                    'last' => (count($streets) - 1) - $last,
                ];
            }
            $ui=0;
            foreach ($firstlastted as $fl) {





                $rap[] = [
                    'adress' => $valorate[$fl['first']]["timestamp"],
                    'time' => date('Y-m-d H:i:s', $valorate[$fl['first']]["timestamp"]),
                    'date' => date('Y-m-d', $valorate[$fl['first']]["timestamp"]),
                    'adress1' => $valorate[$fl['last']]["timestamp"],
                    'time1' => date('Y-m-d H:i:s', $valorate[$fl['last']]["timestamp"]),
                    'date1' => date('Y-m-d', $valorate[$fl['last']]["timestamp"]),
                    'speed' => intval(($valorate[$fl['last']]['speed'] + $valorate[$fl['first']]['speed']) / 2),
                ];
                // var_dump($rap);
                $lcp[] = [
                    'reg_number' => $vehi->getRegNumber(),
                    'mark' => $vehi->getMark(),
                    'type' => $vehi->getType(),
                    'model' => $vehi->getModel(),
                    'trame' => $rap,
                ];
                $ui++;

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
        $x=-1;
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['adress']==$d && $tab[$i]['contact']==1 ){
                $x=$i;
                return $i;
            }
        }

        if($x==-1){
            for($i=0;$i<count($tab);$i++){
                if($tab[$i]['adress']==$d  ){

                    return $i;
                }
            }
        }
        return null;
    }
    public function lastocurencestreet($tab,$d){
        $ind=-1;
        for($i=0;$i<count($tab);$i++){
            if($tab[$i]['adress']==$d &&  $tab[$i]['contact']==1){
                $ind= $i;
            }
        }
        if($ind==-1){
                for($i=0;$i<count($tab);$i++){
                    if($tab[$i]['adress']==$d  ){

                        return $i;
                    }
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
        if($ind==-1){
            for($i=0;$i<count($tab);$i++){
                if($tab[$i]['adress']==$d  ){

                    return $i;
                }
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
        if($ind==-1){
            for($i=0;$i<count($tab);$i++){
                if($tab[$i]['adress']==$d  ){

                    return $i;
                }
            }

        }
        return $ind;
    }

    /**
     * @Rest\Get("/streetoff/{id}",name="hfgfh")
     * @param Request $request
     * @return array
     */
    public function getmyVehicleStreetTraficoffAction(Request $request)
    {
        $id = $request->get('id');
        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);


        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();
        usort($result, function ($a, $b) {
            return $a['timestamp'] >= $b['timestamp'];
        });



        $lcp=array();
        foreach ($result as $vehi) {

            $firstlastted = array();
            $formatted[] = array();
            $dates = array();
            $streets = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {
                $trams = $this->idBoxtrames($vehi->getBox());
                //var_dump($trams);die();
                if(count($trams)>0){
                    foreach ($trams as $user) {
                        if($user["contact"]==0){

                            /*array_push($dates, date('Y-m-d', $user["timestamp"]));*/


                            array_push($streets, $user["street"]);
                            $az =str_replace("T", " ", $user["timestamp"]);
                            $az =str_replace(".000Z", "", $az);
                            $az =str_replace("-", "/", $az);
                            $az =substr_replace($az ,"", -1);
                            $az =substr($az, 1);
                            $user["timestamp"]=$az;
                            array_push($valorate, $user);
                            //var_dump(strtotime($az));;
                            //var_dump(date('Y-m-d H:i:s', strtotime($az)));die();
                            $formatted[] = [
                                'id' => $user["id"],
                                'adress' => $user["street"],
                                'timestamp' => date('Y-m-d H:i:s', strtotime($az)),
                                'time' => date('Y-m-d H:i:s', strtotime($az)),
                                'date' => date('Y-m-d', strtotime($az)),
                                'longitude' => $user["longitude"],
                                'latitude' => $user["latitude"],
                                'angle' => $user["angle"],
                                'speed' => $user["speed"],
                                'contact' => $user["contact"],
                                'box' => $user["box"],

                            ];
                            /*$date = new DateTime($user["timestamp"]);
                             $date->format('Y-m-d H:i:s');*/
                           //var_dump($formatted);die();

                            //}
                        }
                    }

                }
            }
            $k = 0;
            //var_dump(array_unique($streets ));
            $ss = array_values(array_unique($streets));
            $ss1 = array_reverse($ss, true);
            foreach ($ss1 as $uniqdate) {
                //for ($k=130;$k<$val;$k++) {
                //var_dump($uniqdate);
                $first = array_search($uniqdate, $streets); // 0
                // var_dump($first);die();
                $last = array_search($ss1[$k], $streets);
                $k++;
                $firstlastted[] = [
                    'first' => $first,
                    'last' => (count($streets) - 1) - $last,
                ];
            }
            $ui=0;
            foreach ($firstlastted as $fl) {




                $rap[] = [
                    'adress' => $valorate[$fl['first']]["street"],
                    'time' => date('Y-m-d H:i:s', strtotime($valorate[$fl['first']]["timestamp"])),
                    'date' => date('Y-m-d', strtotime($valorate[$fl['first']]["timestamp"])),
                    'adress1' => $valorate[$fl['last']]["street"],
                    'time1' => date('Y-m-d H:i:s', strtotime($valorate[$fl['last']]["timestamp"])),
                    'date1' => date('Y-m-d', strtotime($valorate[$fl['last']]["timestamp"])),
                    'speed' => intval(($valorate[$fl['last']]['speed'] + $valorate[$fl['first']]['speed']) / 2),
                ];
                $lcp[] = [
                    'reg_number' => $vehi->getRegNumber(),
                    'mark' => $vehi->getMark(),
                    'type' => $vehi->getType(),
                    'model' => $vehi->getModel(),
                    'trame' => $rap,
                ];
                $ui++;

            }



        }
        return $lcp;


    }

    /**
     * @Rest\Get("/fuelrap/{id}",name="hfgfh")
     * @param Request $request
     * @return array
     */
    public function getmyfuelTraficoffAction(Request $request)
    {
        $id = $request->get('id');
        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);


        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();



        $lcp=array();
        foreach ($result as $vehi) {

            $firstlastted = array();
            $dates = array();
            $streets = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {
                $trams = $this->idBoxtramesfuel($vehi->getBox());
                if(count($trams)>0){
                    //$formatted[] =[];
                    foreach ($trams as $user) {
                        $formatted[] = [
                                'id' => $user["id"],
                                'adress' => $user["street"],
                                'kilo' => $user["kilo"],
                                'timestamp' => $user["timestamp"],
                                'time' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                'date' => date('Y-m-d', strtotime($user["timestamp"])),
                                'tfu' => $user["tfu"],
                                'tfl' => $user["tfl"],
                                'angle' => $user["angle"],
                                'speed' => $user["speed"],
                                'contact' => $user["contact"],
                                'box' => $user["box"],

                            ];
                        $int= rand(978369709,1007227309);
                        $fordateval[] = [
                            'date' => date("Y-m-d H:i:s",$int),
                            //'date' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                            'value' => $user["tfl"],
                            ];
                        $formattedlab[] = date('Y-m-d H:i:s', strtotime($user["timestamp"]));
                            /*'time' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                        ];*/
                        $formattedtfl[] = $user["tfl"];
                            /*'tfl' => $user["tfl"],
                        ];*/
                            //}
                       // }
                    }
                    $final[]=[
                        'id'=> $vehi->getId(),
                        'model'=> $vehi->getModel(),
                        'mark'=> $vehi->getMark(),
                        'tfu'=> $formatted[count($formatted)-1]['tfu'],
                        'tram'=>$formatted,
                        'labels'=>$formattedlab,
                        'dataset'=>$formattedtfl,
                        'valor'=>$fordateval,

                    ];



                }
            }





        }
        return $final;


    }

    /******/
    /**
     * @Rest\Get("/rapportfinal/{dep}/{end}/{id}",name="hfgfh")
     * @param Request $request
     * @return array
     */
    public function getmyVehiclerappfinalAction(Request $request){
        //var_dump("sdsdsd");die();
        $id = $request->get('id');
        $dep = $request->get('dep');
        $end = $request->get('end');

        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();
        /*usort($result, function ($a, $b) {
            return $a['timestamp'] >= $b['timestamp'];
        });*/

        $lcp=array();
        foreach ($result as $vehi) {

            $firstlastted = array();
            $streets = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {

                unset($trams);
                $trams = $this->idBoxtrames($vehi->getBox());
                unset($formatted);

                if(count($trams)>0){
                    foreach ($trams as $user) {
                            array_push($streets, $user["street"]);
                            array_push($valorate, $user);
                            if(date('Y-m-d', strtotime($user["timestamp"]))<=$end &&
                                date('Y-m-d', strtotime($user["timestamp"]))>=$dep) {
                                //unset($formatted);

                                $formatted[] = [
                                    'id' => $user["id"],
                                    'adress' => $user["street"],
                                    'kilo' => $user["kilo"],
                                    'timestamp' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                    'time' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                    'date' => date('Y-m-d', strtotime($user["timestamp"])),
                                    'time' => date('H:i:s', strtotime($user["timestamp"])),
                                    'longitude' => $user["longitude"],
                                    'latitude' => $user["latitude"],
                                    'angle' => $user["angle"],
                                    'speed' => $user["speed"],
                                    'contact' => $user["contact"],
                                    'box' => $user["box"],
                                    'milage' => $user["milage"],

                                ];

                            }

                    }


                }
            }
            $firstoc = array();
            $traject = array();
            $lastloc = array();
            $vitessmax = array();
            $vitessmoy = array();
            $ic=-1;
            for($c=0;$c<count($formatted);$c++){
                $ic++;
                $vtm=$formatted[$c]['speed'];
                $vtma=$formatted[$c]['speed'];
                array_push($firstoc, $formatted[$c]);
                if($formatted[$c]['contact']==0){
                    for($j=$c+1;$j<count($formatted);$j++){
                        $vtm=$vtm+$formatted[$j]['speed'];
                        if($formatted[$j]['contact']==1){
                            array_push($lastloc, $formatted[$j]);
                            break;
                        }
                    }
                }else{
                    for($j=$c+1;$j<count($formatted);$j++){
                        $vtm=$vtm+$formatted[$j]['speed'];
                        if($vtma < $formatted[$j]['speed'] ){
                            $vtma = $formatted[$j]['speed'];
                        }
                        if($formatted[$j]['contact']==0){
                            array_push($lastloc, $formatted[$j]);
                            break;
                        }
                    }
                    //array_push($firstoc, $formatted[$c]);
                }
                $vtm = $vtm / $j;
                array_push($vitessmax, $vtma);
                array_push($vitessmoy, round($vtm));
                $c=$j-1;
            }
            if(count($formatted)-$ic >=3){
                /*var_dump("aaaa");
                die();*/
                array_push($firstoc, $formatted[$ic+1]);
                array_push($lastloc, $formatted[(count($formatted)-1)]);
            }

            //unset($traject);
            for($c=0;$c<count($lastloc);$c++){
                if($firstoc[$c]["contact"] == 0){
                    $traject[] = [
                        'adress' => $firstoc[$c]["adress"],
                        'adress1' => $lastloc[$c]["adress"],
                        'date' => $firstoc[$c]["timestamp"],
                        'date1' => $lastloc[$c]["timestamp"],
                        'maxspeed' => $user["street"],
                        'speedmoy' => $user["street"],
                        'contact' => $firstoc[$c]["contact"],
                        'maxspeed' => "-",
                        'speedmoy' => "-",
                        'milage' =>"-",
                        'idle' =>"-",
                        'arret' =>(date('H:i:s',(strtotime($lastloc[$c]["time"])-strtotime($firstoc[$c]["time"]))-3600)),
                    ];
                }else{
                    $traject[] = [
                        'adress' => $firstoc[$c]["adress"],
                        'adress1' => $lastloc[$c]["adress"],
                        'date' => $firstoc[$c]["timestamp"],
                        'date1' => $lastloc[$c]["timestamp"],
                        'maxspeed' => $user["street"],
                        'speedmoy' => $user["street"],
                        'contact' => $firstoc[$c]["contact"],
                        'maxspeed' => $vitessmax[$c],
                        'speedmoy' => $vitessmoy[$c],
                        'milage' =>($lastloc[$c]["milage"] - $firstoc[$c]["milage"])/1000,
                        'arret' =>(date('H:i:s',(strtotime($lastloc[$c]["time"])-strtotime($firstoc[$c]["time"]))-3600)),
                        'idle' =>(date('H:i:s',(strtotime($lastloc[$c]["time"])-strtotime($firstoc[$c]["time"]))-3600)),

                    ];
                }
            }
            $nbrtajon=0;
            $nbrtajoff=0;
            $kmtot=0;
            $totidle="00:00:00";
            $totlarret="00:00:00";
            $alo=0;
            $bb=0;
          /*  foreach ($traject as $traj) {
                if($traj['contact'] ==0){
                    $nbrtajoff++;
                    $totlarret=$totlarret+strtotime($traj['arret']);
                }else{
                    $nbrtajon++;
                    $kmtot=$kmtot+$traj['milage'];
                    $totidle=$totidle+strtotime($traj['idle']);

                }
            }*/
           /* var_dump("*******");
            var_dump($totlarret);*/
            //var_dump($totidle);
            /*if(count($traject)>0){
                //var_dump($traject);
                var_dump(strtotime($traject[0]['idle']));
                var_dump(($traject[0]['idle']));
                var_dump(strtotime($traject[2]['idle']));
                var_dump(($traject[2]['idle']));
                $secs = strtotime($traject[2]['idle'])-strtotime("00:00:00");
                var_dump(date("H:i:s",strtotime($traject[0]['idle'])+$secs));
                var_dump((strtotime($traject[0]['idle'])+$secs));
                die();
            }*/

            foreach ($traject as $traj) {
                if($traj['contact'] ==0){
                    $nbrtajoff++;
                    $secs = strtotime($traj['arret'])-strtotime("00:00:00");
                    $totlarret=$totlarret+$secs;
                }else{
                    $nbrtajon++;
                    $kmtot=$kmtot+$traj['milage'];
                    $secs = strtotime($traj['idle'])-strtotime("00:00:00");
                    $totidle=$totidle+$secs;
                }
            }
            $c=0;
            $traject = array_values($traject);
            $maxispeed=0;
            $moyspeed=0;
            foreach ($traject as $traj) {
                $moyspeed = $moyspeed + $traj['maxspeed'];
                if($traj['maxspeed'] > $maxispeed){
                    $maxispeed =$traj['maxspeed'] ;
                }
            }
            $moyspeed=$moyspeed/count($traject);


            if($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"){
               // var_dump((($nbrtajon )+($nbrtajoff )));die();
                if((($nbrtajon )+($nbrtajoff )) % 2 == 1)
                    $x=($nbrtajon /2)+($nbrtajoff /2) - 0.5;
                else
                    $x=($nbrtajon /2)+($nbrtajoff /2);
                $lcp[] = [
                    'reg_number' => $vehi->getRegNumber(),
                    'mark' => $vehi->getMark(),
                    'type' => $vehi->getType(),
                    'nbrtraj' => $x,
                    'nbrtrajon' => $nbrtajon /2,
                    'nbrtrajoff' => $nbrtajoff /2,
                    'maxispeed' => $maxispeed,
                    'moyspeed' => round($moyspeed),
                    'tempon' => date('H:i:s',$totidle-3600),
                    'tempoff' => date('H:i:s',$totlarret-3600),
                    'kmt' => $kmtot,
                    'model' => $vehi->getModel(),
                    'datedep' => $traject[0]['date'],
                    'dateend' => $traject[count($traject)-1]['date1'],
                    'trame' =>  $traject,
                ];
            }


        }

        return $lcp;
    }

    /******/
    /**
     * @Rest\Get("/rapportalertvitesse/{dep}/{end}/{id}",name="vitesse")
     * @param Request $request
     * @return array
     */
    public function getmyVehiclervitessAction(Request $request){
        $id = $request->get('id');
        $dep = $request->get('dep');
        $end = $request->get('end');

        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);


        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();


        $lcp=array();
        foreach ($result as $vehi) {

            $drivers = array();
            $streets = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {
                unset($trams);
                $trams = $this->idBoxtrames($vehi->getBox());
                unset($formatted);
                unset($drivers);
                foreach ($vehi->getAlters() as $aler){
                    if($aler->getType()=="vitesse") {
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
                }
                if(count($trams)>0){
                    foreach ($trams as $user) {
                        array_push($streets, $user["street"]);
                        array_push($valorate, $user);
                        if(date('Y-m-d', strtotime($user["timestamp"]))<=$end &&
                            date('Y-m-d', strtotime($user["timestamp"]))>=$dep) {
                            //unset($formatted);
                            $formatted[] = [
                                'id' => $user["id"],
                                'adress' => $user["street"],
                                'timestamp' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                'time' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                'date' => date('Y-m-d', strtotime($user["timestamp"])),
                                'time' => date('H:i:s', strtotime($user["timestamp"])),
                                'longitude' => $user["longitude"],
                                'latitude' => $user["latitude"],
                                'angle' => $user["angle"],
                                'speed' => $user["speed"],
                                'contact' => $user["contact"],
                                'box' => $user["box"],
                                'milage' => $user["milage"],

                            ];
                        }

                    }


                }
                $alertano= array();
                //unset($alertano);

                if(count($trams)>0 && count($drivers)>0) {
                    foreach ($drivers as $aler) {
                        foreach ($formatted as $tram) {


                             //if($tram["speed"]>3){
                             if($aler["valeur"]<$tram["speed"]){
                                 //var_dump(count($alertano));
                                 array_push($alertano,$tram);
                         }

                        }

                    }
                }

            }
        $lcp[]=[
            "id"=>$vehi->getId(),
            "mark"=>$vehi->getMark(),
            "model"=>$vehi->getModel(),
            "type"=>$vehi->getType(),
            "regnumber"=>$vehi->getRegNumber(),
            "alert"=>$alertano,
        ];

        }

        return $lcp;
    }
    public function fusiontraject($a,$b){
        $a['date1']=$b['date1'];
        $a['idle']= date('H:i:s',strtotime($a['idle'] )+strtotime($b['idle']));
        return $a;
    }
    /******/
    /**
     * @Rest\Get("/rapportalertgeozone/{dep}/{end}/{id}",name="geozonne")
     * @param Request $request
     * @return array
     */
    public function getmyVehiclergeozoneAction(Request $request){
        $id = $request->get('id');
        $dep = $request->get('dep');
        $end = $request->get('end');

        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);


        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();


        $lcp=array();
        foreach ($result as $vehi) {

            $drivers = array();
            $streets = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {
                unset($trams);
                $trams = $this->idBoxtrames($vehi->getBox());
                unset($formatted);
                unset($drivers);
                foreach ($vehi->getAlters() as $aler){
                    if($aler->getType()=="geozone") {
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
                }
                if(count($trams)>0){
                    foreach ($trams as $user) {
                        array_push($streets, $user["street"]);
                        array_push($valorate, $user);
                            if(date('Y-m-d', strtotime($user["timestamp"]))<=$end &&
                                date('Y-m-d', strtotime($user["timestamp"]))>=$dep) {
                            //unset($formatted);
                            $formatted[] = [
                                'id' => $user["id"],
                                'adress' => $user["street"],
                                'timestamp' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                'time' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                'date' => date('Y-m-d', strtotime($user["timestamp"])),
                                'time' => date('H:i:s', strtotime($user["timestamp"])),
                                'longitude' => $user["longitude"],
                                'latitude' => $user["latitude"],
                                'angle' => $user["angle"],
                                'speed' => $user["speed"],
                                'contact' => $user["contact"],
                                'box' => $user["box"],
                                'milage' => $user["milage"],

                            ];
                        }

                    }


                }
                $alertano= array();
                //unset($alertano);

                if(count($trams)>0 && count($drivers)>0) {
                    foreach ($drivers as $aler) {
                        foreach ($formatted as $tram) {
                            /*$rapp=sqrt(pow(($tram['longitude']-$aler["valeur"]),2)+
                                pow(($tram['latitude']-$aler["valeur1"]),2));
                            $pp=(pow(($tram['longitude']-$aler["valeur"]),2)+
                                pow(($tram['latitude']-$aler["valeur1"]),2));
                            var_dump($rapp);*/
                            $rapp=$this->distance($tram['latitude'],$tram['longitude'],
                                $aler["valeur1"],$aler["valeur"],"M");
                            //var_dump($rapp*1609.34);
                            if(abs($rapp*1609.34<$aler["radus"])) {
                                $es = "i";
                            }else{
                                $es="o";
                            }
                                $pred = [
                                    'tram' => $tram,
                                    'es' => $es,
                                ];
                                array_push($alertano,$pred);


                        }

                    }
                }

            }
            $finalalertano =array();
            for($c=0;$c<count($alertano)-1;$c++) {
                if($alertano[$c]['es'] !=$alertano[$c+1]['es']){
                  array_push($finalalertano,$alertano[$c+1]) ;
                }
            }
            $finalalertano1 =array();

            $lcp[]=[
                "id"=>$vehi->getId(),
                "regnumber"=>$vehi->getRegNumber(),
                "type"=>$vehi->getType(),
                "mark"=>$vehi->getMark(),
                "model"=>$vehi->getModel(),
                "alert"=>$finalalertano,
            ];

        }
        $tabalo=array();
        $tabali=array();
        for($c=0;$c<count($lcp);$c++) {
            $nbri=0;
            $nbro=0;
            $timei="";
            $timeo="";
            $nbrto=0;//daclof
            foreach ($lcp[$c]["alert"] as $t) {
                if($t["es"]=="i"){
                    $nbri++;
                    array_push($tabali,$t["tram"]["timestamp"]);
                    //(date('H:i:s',(strtotime($lastloc[$c]["time"])-strtotime($firstoc[$c]["time"]))-3600));
                }
                else{
                    $nbro++;
                    array_push($tabalo,$t["tram"]["timestamp"]);
                }
            }
            $lcp[$c]['nbri']=$nbri;
            $lcp[$c]['nbro']=$nbro;
            /*var_dump($tabali);
            var_dump($tabalo);
            var_dump($tabali[count($tabali)-1]);
            var_dump($tabali[0]);
            die();*/
            $timei=(date('H:i:s',(strtotime($tabali[count($tabali)-1])-strtotime($tabali[0]))-3600));;
            $timeo=(date('H:i:s',(strtotime($tabalo[count($tabalo)-1])-strtotime($tabalo[0]))-3600));;
            $lcp[$c]['timein']=$timei;
            $lcp[$c]['timeout']=$timeo;
            unset($tabali);
            unset($tabalo);
        }

        return $lcp;
    }
    /**
     * @Rest\Get("/rapportalertgeozones/{dep}/{end}/{id}",name="geozonness")
     * @param Request $request
     * @return array
     */
    public function getmyVehiclergeozonesAction(Request $request){
        $id = $request->get('id');
        $dep = $request->get('dep');
        $end = $request->get('end');

        $user1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);


        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->findAll();


        $lcp=array();
        foreach ($result as $vehi) {

            $drivers = array();
            $streets = array();
            $valorate = array();
            if ($vehi->getFlot()->getComapny()->getId() == $user1->getCompany()->getId() &&
                (!empty($vehi->getBox()) || $vehi->getBox() != null)
                && $vehi->getType() != "personne" && $vehi->getType() != "depot"
            ) {
                unset($trams);
                $trams = $this->idBoxtrames($vehi->getBox());
                unset($formatted);
                unset($drivers);
                foreach ($vehi->getAlters() as $aler){
                    if($aler->getType()=="geozone") {
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
                }
                if(count($trams)>0){
                    foreach ($trams as $user) {
                        array_push($streets, $user["street"]);
                        array_push($valorate, $user);
                        if(date('Y-m-d', strtotime($user["timestamp"]))<=$end &&
                            date('Y-m-d', strtotime($user["timestamp"]))>=$dep) {
                            //unset($formatted);
                            $formatted[] = [
                                'id' => $user["id"],
                                'adress' => $user["street"],
                                'timestamp' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                'time' => date('Y-m-d H:i:s', strtotime($user["timestamp"])),
                                'date' => date('Y-m-d', strtotime($user["timestamp"])),
                                'time' => date('H:i:s', strtotime($user["timestamp"])),
                                'longitude' => $user["longitude"],
                                'latitude' => $user["latitude"],
                                'angle' => $user["angle"],
                                'speed' => $user["speed"],
                                'contact' => $user["contact"],
                                'box' => $user["box"],
                                'milage' => $user["milage"],

                            ];
                        }

                    }


                }
                $alertano= array();
                //unset($alertano);

                if(count($trams)>0 && count($drivers)>0) {
                    foreach ($drivers as $aler) {
                        foreach ($formatted as $tram) {
                            /*$rapp=sqrt(pow(($tram['longitude']-$aler["valeur"]),2)+
                                pow(($tram['latitude']-$aler["valeur1"]),2));
                            $pp=(pow(($tram['longitude']-$aler["valeur"]),2)+
                                pow(($tram['latitude']-$aler["valeur1"]),2));
                            var_dump($rapp);*/
                            $rapp=$this->distance($tram['latitude'],$tram['longitude'],
                                $aler["valeur1"],$aler["valeur"],"M");
                            //var_dump($rapp*1609.34);
                            if(abs($rapp*1609.34<$aler["radus"])) {
                                $es = "i";
                            }else{
                                $es="o";
                            }
                            $pred = [
                                'tram' => $tram,
                                'es' => $es,
                            ];
                            array_push($alertano,$pred);


                        }

                    }
                }

            }
            $finalalertano =array();
            for($c=0;$c<count($alertano)-1;$c++) {
                if($alertano[$c]['es'] !=$alertano[$c+1]['es']){
                    array_push($finalalertano,$alertano[$c+1]) ;
                }
            }
            $finalalertano1 =array();

            $lcp[]=[
                "id"=>$vehi->getId(),
                "regnumber"=>$vehi->getRegNumber(),
                "type"=>$vehi->getType(),
                "mark"=>$vehi->getMark(),
                "model"=>$vehi->getModel(),
                "alert"=>$finalalertano,
            ];

        }
        $tabalo=array();
        $tabali=array();
        for($c=0;$c<count($lcp);$c++) {
            $nbri=0;
            $nbro=0;
            $timei="";
            $timeo="";
            $nbrto=0;//daclof
            foreach ($lcp[$c]["alert"] as $t) {
                if($t["es"]=="i"){
                    $nbri++;
                    array_push($tabali,$t["tram"]["timestamp"]);
                    //(date('H:i:s',(strtotime($lastloc[$c]["time"])-strtotime($firstoc[$c]["time"]))-3600));
                }
                else{
                    $nbro++;
                    array_push($tabalo,$t["tram"]["timestamp"]);
                }
            }
            $lcp[$c]['nbri']=$nbri;
            $lcp[$c]['nbro']=$nbro;
            /*var_dump($tabali);
            var_dump($tabalo);
            var_dump($tabali[count($tabali)-1]);
            var_dump($tabali[0]);
            die();*/
            $timei=(date('H:i:s',(strtotime($tabali[count($tabali)-1])-strtotime($tabali[0]))-3600));;
            $timeo=(date('H:i:s',(strtotime($tabalo[count($tabalo)-1])-strtotime($tabalo[0]))-3600));;
            $lcp[$c]['timein']=$timei;
            $lcp[$c]['timeout']=$timeo;
            unset($tabali);
            unset($tabalo);
        }
        //var_dump($lcp);die();
        $zones=array();
        foreach ($lcp as $l) {
            $alo=$l["alert"][0]["tram"]["id"];
            var_dump($alo);
            foreach ($alo as $t) {
                //var_dump($t);
                array_push($zones,$t["adress"]);
            }
        }
        die();
        //var_dump($zones);die();
        return $lcp;
    }
    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else {
            return $miles;
        }
    }


}
