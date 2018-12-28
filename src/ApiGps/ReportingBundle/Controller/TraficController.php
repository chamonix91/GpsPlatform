<?php

namespace ApiGps\ReportingBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;


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
                'box' => $user->getBox()->getImei(),

            ];
        }
        //var_dump(count($formatted));die();
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
        //var_dump(count($formatted));die();
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
                            array_push($valorate, $user);
                            //var_dump($user["street"]);die();
                            array_push($streets, $user["street"]);

                            $formatted[] = [
                                'id' => $user["id"],
                                'adress' => $user["street"],
                                'timestamp' => $user["timestamp"],
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

}
