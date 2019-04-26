<?php

namespace ApiGps\ReportingBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class DashbordController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/nbrflotte/{id}")
     * @param Request $request
     */
    public function getnbrflotteAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findBycomapny($company);
        return count($result);
    }
    /**
     * @Rest\Get("/nbrobject/{id}")
     * @param Request $request
     */
    public function getnbrobjectAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findBycomapny($company);
        $x=0;
        for($c=0;$c<count($result);$c++){
            $x=$x+count($result[$c]->getVehicles());
        }
        return $x;
    }
    /**
     * @Rest\Get("/nbrbox/{id}")
     * @param Request $request
     */
    public function getnbrboxAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->findAll();
        $x=array();
        for($c=0;$c<count($result);$c++){
            if($result[$c]->getCompany()->getId()==$id){
                array_push($x,$result[$c]);
            }
        }
            //->findBycomapny($company);
        return count($x);
    }
    /**
     * @Rest\Get("/insurence/{id}")
     * @param Request $request
     */
    public function getinsuranceAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findBycomapny($company);
        $x=array();
        $x1=array();
        for($c=0;$c<count($result1);$c++){
            for($j=0;$j<count($result1[$c]->getVehicles());$j++){
                if($result1[$c]->getVehicles()[$j]->getType() != "personne" && $result1[$c]->getVehicles()[$j]->getType() != "depot")
                    array_push($x,$result1[$c]->getVehicles()[$j]);
            }
        }
        $dx=new \DateTime('now');
        /*var_dump($dx->format('m'));
        var_dump(date('m',$x[0]->getInsurance()->sec));
        var_dump(date('Y-m',$x[0]->getInsurance()->sec) - $dx->format('Y-m'));die();*/
        for($c=0;$c<count($x);$c++){
            $a=date('m',$x[$c]->getInsurance()->sec) - $dx->format('m');
            if($a<0){
                $a+=12;
            }
            if($a < 2){
                $formatted = [
                    'reg_number' => $x[$c]->getRegNumber(),
                    'id' => $x[$c]->getId(),
                    'type' => $x[$c]->getType(),
                    'mark' => $x[$c]->getMark(),
                    'model' => $x[$c]->getModel(),
                    'technical_visit' => date('m/d',$x[$c]->getTechnicalVisit()->sec),
                    'insurance' => date('m/d',$x[$c]->getInsurance()->sec),
                    'vignettes' => date('m/d',$x[$c]->getVignettes()->sec),
                ];
                array_push($x1,$formatted);
            }
        }

        return $x1;
    }
    /**
     * @Rest\Get("/technik/{id}")
     * @param Request $request
     */
    public function gettechnikAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findBycomapny($company);
        $x=array();
        $x1=array();
        for($c=0;$c<count($result1);$c++){
            for($j=0;$j<count($result1[$c]->getVehicles());$j++){
                if($result1[$c]->getVehicles()[$j]->getType() != "personne" && $result1[$c]->getVehicles()[$j]->getType() != "depot")
                    array_push($x,$result1[$c]->getVehicles()[$j]);
            }
        }

        $dx=new \DateTime('now');
        /*var_dump($dx->format('m'));
        var_dump(date('m',$x[0]->getInsurance()->sec));
        var_dump(date('Y-m',$x[0]->getInsurance()->sec) - $dx->format('Y-m'));die();*/
        for($c=0;$c<count($x);$c++){
            $a=date('m',$x[$c]->getTechnicalVisit()->sec) - $dx->format('m');
            if($a<0){
                $a+=12;
            }
            if($a < 2){
                $formatted = [
                    'reg_number' => $x[$c]->getRegNumber(),
                    'id' => $x[$c]->getId(),
                    'type' => $x[$c]->getType(),
                    'mark' => $x[$c]->getMark(),
                    'model' => $x[$c]->getModel(),
                    'technical_visit' => date('m/d',$x[$c]->getTechnicalVisit()->sec),
                    'insurance' => date('m/d',$x[$c]->getInsurance()->sec),
                    'vignettes' => date('m/d',$x[$c]->getVignettes()->sec),
                ];
                array_push($x1,$formatted);
            }
        }
        return $x1;
    }
    /**
     * @Rest\Get("/vigni/{id}")
     * @param Request $request
     */
    public function getvigniAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findBycomapny($company);
        $x=array();
        $x1=array();
        for($c=0;$c<count($result1);$c++){
            for($j=0;$j<count($result1[$c]->getVehicles());$j++){
                if($result1[$c]->getVehicles()[$j]->getType() != "personne" && $result1[$c]->getVehicles()[$j]->getType() != "depot")
                    array_push($x,$result1[$c]->getVehicles()[$j]);
            }
        }
        $dx=new \DateTime('now');
        /*var_dump($dx->format('m'));
        var_dump(date('m',$x[0]->getInsurance()->sec));
        var_dump(date('Y-m',$x[0]->getInsurance()->sec) - $dx->format('Y-m'));die();*/
        for($c=0;$c<count($x);$c++){
            $a=date('m',$x[$c]->getVignettes()->sec) - $dx->format('m');
            if($a<0){
                $a+=12;
            }
            if($a < 2){
                $formatted = [
                    'reg_number' => $x[$c]->getRegNumber(),
                    'id' => $x[$c]->getId(),
                    'type' => $x[$c]->getType(),
                    'mark' => $x[$c]->getMark(),
                    'model' => $x[$c]->getModel(),
                    'technical_visit' => date('m/d',$x[$c]->getTechnicalVisit()->sec),
                    'insurance' => date('m/d',$x[$c]->getInsurance()->sec),
                    'vignettes' => date('m/d',$x[$c]->getVignettes()->sec),
                ];
                array_push($x1,$formatted);
            }
        }
        return $x1;
    }
    /**
     * @Rest\Get("/vidange/{id}")
     * @param Request $request
     */
    public function getvidangeAction(Request $request)
    {

        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result1 = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findBycomapny($company);
        $x=array();
        $x1=array();
        for($c=0;$c<count($result1);$c++){
            for($j=0;$j<count($result1[$c]->getVehicles());$j++){
                if($result1[$c]->getVehicles()[$j]->getType() != "personne" &&
                    $result1[$c]->getVehicles()[$j]->getType() != "depot"
                    && !empty($result1[$c]->getVehicles()[$j]->getBox())
                    && !empty($result1[$c]->getVehicles()[$j]->getBox()->getTrame())
                )
                    array_push($x,$result1[$c]->getVehicles()[$j]);
            }
        }



        for($c=0;$c<count($x);$c++){
            //var_dump($x[$c]->getBox()->getTrame()[(count($x[$c]->getBox()->getTrame()))-1]->getTotalMileage());die();
            if($x[$c]->getVidengetime() >0
            && $x[$c]->getVidengekm() ==0){
                var_dump("aaa");
                $k=$x[$c]->getBox()->getTrame()[(count($x[$c]->getBox()->getTrame()))-1]->getTotalMileage();
                if($k % 50 ==0 || $x[$c]->getVidengetime() -($k % $x[$c]->getVidengetime() )<=50){
                    $formatted = [
                        'reg_number' => $x[$c]->getRegNumber(),
                        'id' => $x[$c]->getId(),
                        'type' => $x[$c]->getType(),
                        'mark' => $x[$c]->getMark(),
                        'model' => $x[$c]->getModel(),
                        'msg' => "Videnge immédiatement",
                    ];
                    array_push($x1,$formatted);
                }
                elseif($k % 50 ==0 || $x[$c]->getVidengetime() -($k % $x[$c]->getVidengetime() )<=50){
                    $ass=$x[$c]->getVidengetime() -($k % $x[$c]->getVidengetime()  );
                    $formatted = [
                        'reg_number' => $x[$c]->getRegNumber(),
                        'id' => $x[$c]->getId(),
                        'type' => $x[$c]->getType(),
                        'mark' => $x[$c]->getMark(),
                        'model' => $x[$c]->getModel(),
                        'msg' => "Vidange dans ".$ass." Heurs",
                    ];
                    array_push($x1,$formatted);
                }

            }
            elseif ($x[$c]->getVidengekm() >0
                && $x[$c]->getVidengetime() ==0){
                $k=$x[$c]->getBox()->getTrame()[(count($x[$c]->getBox()->getTrame()))-1]->getTotalMileage();
                dump($x[$c]->getBox()->getTrame()[(count($x[$c]->getBox()->getTrame()))-1]);
                if($k % 5000 ==0 ){
                    $formatted = [
                        'reg_number' => $x[$c]->getRegNumber(),
                        'id' => $x[$c]->getId(),
                        'type' => $x[$c]->getType(),
                        'mark' => $x[$c]->getMark(),
                        'model' => $x[$c]->getModel(),
                        'msg' => "Videnge immédiatement",
                    ];
                    array_push($x1,$formatted);
                }
                elseif ( $x[$c]->getVidengekm() -($k % $x[$c]->getVidengekm() )<=1000){
                    $ass=$x[$c]->getVidengekm() -($k % $x[$c]->getVidengekm()  );
                    $formatted = [
                        'reg_number' => $x[$c]->getRegNumber(),
                        'id' => $x[$c]->getId(),
                        'type' => $x[$c]->getType(),
                        'mark' => $x[$c]->getMark(),
                        'model' => $x[$c]->getModel(),
                        'msg' => "Vidange dans ".$ass." KM",
                    ];
                    array_push($x1,$formatted);
                }
            }

        }
        var_dump("aaaassd");doe();
        return $x1;
    }
    /**
     * @Rest\Get("/pannebox/{id}")
     * @param Request $request
     */
    public function getpboxAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($id);
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->findAll();
        $x=array();
        for($c=0;$c<count($result);$c++){
            if($result[$c]->getCompany()->getId()==$id){

                array_push($x,$result[$c]);
            }
        }

        $d1=new \DateTime('now');
        $d2=date('Y.m.d',strtotime("-2 days"));

        $final=array();
        for($i=0;$i<count($x);$i++) {
            $resTrame= array();
            //if (!empty($x[$i]->getBox())){
                $trames = $x[$i]->getTrame();
                for ($j = 0; $j < count($trames); $j++) {
                    //$time= Date("d-m-Y",$trames[$j]->getTimestamp()); $trames[$j]->getTimestamp()
                    //date('Y-m-d',$result[$i]->getBox()->getTrame()[$j]->getTimestamp())
                    //var_dump($d2);
                    //var_dump(strtotime(substr($trames[$j]->getTimestamp(),0,24)));
                    //var_dump(date('Y-m-d', strtotime(substr($trames[$j]->getTimestamp(),0,24))));die();
                    if ((date('Y-m-d', strtotime(substr($trames[$j]->getTimestamp(),0,24))) >= $d2) &&
                        (date('Y-m-d', strtotime(substr($trames[$j]->getTimestamp(),0,24))) <= $d1)) {
                        //var_dump((date('Y-m-d', $trames[$j]->getTimestamp()) ));

                        $resTrame[$c] = $trames[$j];

                    }
                }
            if(count($resTrame)==0 && count($trames)>0){
                $formatted = [
                    'imei' => $x[$i]->getImei(),
                    'mark' => $x[$i]->getMark(),
                    'model' => $x[$i]->getModel(),
                    //'last' => $x[$i]->getTrame()[count($x[$i]->getTrame())-1]->getTimestamp(),
                    //'last' => date('Y-m-d', strtotime(substr($trames[$j]->getTimestamp(),0,24))),
                    'last' => $x[$i]->getTrame()[count($x[$i]->getTrame())-1]->getTimestamp(),
                    //'last' => date('Y-m-d',($x[$i]->getTrame()[count($x[$i]->getTrame())-1]->getTimestamp())),
                ];
                array_push($final,$formatted);
            }
            }

        //}
        return ($final);
    }
    /**
     * @Rest\Get("/myflotdash/{id}",name="hfgekkkkkalfh")
     * @param Request $request
     * @return view
     */
    public function getmyrealVehicleAction(Request $request)
    {
        //var_dump("ssssfsds");die();
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
                unset($operat);
                $datearray=array();
                foreach ($result->getOperations() as $op){
                    array_push($datearray,date('Y-m-d', $op->getOperationDate()->sec));
                    $operat[] = [
                        'id' => $op->getId(),
                        'libele' => $op->getLibelle(),
                        'type' => $op->getType(),
                        'price' => $op->getPrice(),
                        'operation_date' => date('Y-m-d', $op->getOperationDate()->sec),
                    ];
                }
                $datearrayu=array_unique($datearray);
                $ope1=array();
                unset($bydatee);
                foreach ($datearrayu as $dateu){
                    unset($ope1);
                    //var_dump($dateu);
                    foreach ($operat as $op2){
                        if($dateu==$op2["operation_date"]){
                            $ope1[]=$op2;
                            //array_push($ope1,$op2["operation_date"]);
                        }
                    }
                    //var_dump($ope);
                    $bydatee[]=[
                        'date'=>$dateu,
                        'alert'=>$ope1,
                    ];
                }
                unset($loc);
                foreach ($bydatee as $by){

                    $price_assurence =0;
                    $price_vidange =0;
                    $price_vignette =0;
                    $price_entretien =0;
                    $price_reparation =0;
                    foreach ($by['alert'] as $al){
                        if($al['type'] =="assurence"){
                            $price_assurence =$price_assurence+$al['price'];
                        }
                        elseif($al['type']=="vidange"){
                            $price_vidange =$price_vidange+$al['price'];
                        }
                        elseif($al['type']=="vignette"){
                            $price_vignette =$price_vignette+$al['price'];
                        }
                        elseif($al['type']=="entretien"){
                            $price_entretien =$price_entretien+$al['price'];
                        }
                        else{
                            $price_reparation =$price_reparation+$al['price'];
                        }
                    }
                    //var_dump($by);
                    $loc[]=[
                        'data' => $by['date'],
                        'assurence' => $price_assurence,
                        'vidange' => $price_vidange,
                        'vignette' => $price_vignette,
                        'entretien' => $price_entretien,
                        'reparation' => $price_reparation,
                        'total'=> $price_assurence+$price_vidange+$price_vignette+$price_entretien+$price_reparation,
                    ];
                }
                }
                $loc1[]=[
                    'reg_number'=>$result->getRegNumber(),
                    'al'=>$loc,
                    'total'=>0,
                ];

            }
            $xx=0;
        foreach ($loc1 as $by){
            $tot=0;
            foreach ($by['al'] as $b){

                $tot=$tot+$b['total'];

            }
            $loc1[$xx]['total']=$tot;
            $xx++;
        }
        return ($loc1);
            return $formatted;
        //return "aaaa";
    }
    /**
     * @Rest\Get("/panneboxvehi/{id}",name="louna")
     * @param Request $request
     * @return view
     */
    public function getmypanneboxVehicleAction(Request $request)
    {
        //var_dump("ssssfsds");die();
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
        $d1=new \DateTime('now');
        $d2=date('Y.m.d',strtotime("-2 days"));
        foreach ($results as $result) {
            if($result->getFlot()->getComapny()->getId()==$user->getCompany()->getId() &&
                (!empty($result->getBox()) || $result->getBox() != null)
                && $result->getType()!="personne" && $result->getType()!="depot"
            ) {
                $ispanne=$result->getPanne();
               if($result->getPanne()){
                   $ispanne == true;
               }
               $trames=array();
               $trames=$result->getBox()->getTrame();
                usort($trames, function ($a, $b) {
                    return $a->getTimestamp() >= $b->getTimestamp();
                });
                $isboxpanne=false;
                if(count($trames)>0) {
                    $pos = strpos($trames[count($trames) - 1]->getTimestamp(), "T");

                    if ($pos == false) {
                        $az = date('Y-m-d H:i:s', $trames[count($trames) - 1]->getTimestamp());

                    } else {
                        $az = str_replace("T", " ", $trames[count($trames) - 1]->getTimestamp());
                        $az = str_replace(".000Z", "", $az);
                        $az = str_replace("-", "/", $az);
                        $az = substr_replace($az, "", -1);
                        $az = substr($az, 1);
                    }

                    //var_dump($trames[count($trames)-1]->getTimestamp());die();
                    if (($az >= $d2) &&
                        ($az <= $d1)) {
                        //var_dump((date('Y-m-d', $trames[$j]->getTimestamp()) ));

                        $isboxpanne = true;
                        $lasttrame = $az;

                    }
                }
                else{
                    $az="";
                }


                if($isboxpanne && $ispanne){
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'imei' => $result->getBox()->getImei(),
                        'flot' => $result->getFlot()->getId(),
                        'id' => $result->getId(),
                        'ispanne' => "X",
                        'isboxpanne' => "X",
                        'lasttrame' => $az,
                    ];
                }
                elseif (!$isboxpanne && $ispanne){
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'imei' => $result->getBox()->getImei(),
                        'flot' => $result->getFlot()->getId(),
                        'id' => $result->getId(),
                        'ispanne' => "X",
                        'lasttrame' => $az,
                    ];
                }
                elseif ($isboxpanne && !$ispanne){
                    $formatted[] = [
                        'reg_number' => $result->getRegNumber(),
                        'imei' => $result->getBox()->getImei(),
                        'flot' => $result->getFlot()->getId(),
                        'id' => $result->getId(),
                        'isboxpanne' => "X",
                        'lasttrame' => $az,
                    ];
                }


            }

        }
        return $formatted;
        //return "aaaa";
    }

    /**
     * @Rest\Get("/depvehi/{id}",name="lou4a")
     * @param Request $request
     * @return view
     */
    public function getpaymentbymonthAction(Request $request)
    {
        //var_dump("sdsdsd");die();
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
        $arraudates=array();
        foreach ($results as $result) {
            if ($result->getFlot()->getComapny()->getId() == $user->getCompany()->getId() &&
                (!empty($result->getBox()) || $result->getBox() != null)
                && $result->getType() != "personne" && $result->getType() != "depot"
            ) {

                foreach ($result->getOperations() as $op) {
                    array_push($arraudates,date('Y-m-d', $op->getOperationDate()->sec));
                    $operat[] = [
                        'id' => $op->getId(),
                        'libele' => $op->getLibelle(),
                        'type' => $op->getType(),
                        'price' => $op->getPrice(),
                        'operation_date' => date('Y-m-d', $op->getOperationDate()->sec),
                    ];
                }

            }
        }
        $arraudates=array_unique($arraudates);
        usort($operat, function ($a, $b) {
            return $a['operation_date'] >= $b['operation_date'];
        });
        usort($arraudates, function ($a, $b) {
            return $a >= $b;
        });
        $arraudates1=array();
        $arraudates2=array();
        $arraudates3=array();

        foreach ($arraudates as $op1) {
            array_push($arraudates1,$op1);
        }

        foreach ($arraudates1 as $op2) {
            $depence=0;
            foreach ($operat as $op3) {
                if($op3['operation_date']==$op2){
                    $depence=$depence+$op3['price'];
                }
            }
            array_push($arraudates2,$depence);
            array_push($arraudates3,$op2);
            /*$finaly[] = [
                'price' => $depence,
                'operation_date' => $op2
            ];*/
        }
        $finaly=[
            'price' => $arraudates2,
            'operation_date' => $arraudates3,
        ];
        return $finaly;


    }

    /**
     * @Rest\Get("/myflotdashh/{id}",name="hfgekkkkkkddkdalfh")
     * @param Request $request
     * @return view
     */
    public function getmyrealVehiclesAction(Request $request)
    {
        //var_dump("ssssfsds");die();
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
                unset($operat);
                $datearray=array();
                foreach ($result->getOperations() as $op){
                    array_push($datearray,date('Y-m-d', $op->getOperationDate()->sec));
                    $operat[] = [
                        'id' => $op->getId(),
                        'libele' => $op->getLibelle(),
                        'type' => $op->getType(),
                        'price' => $op->getPrice(),
                        'operation_date' => date('Y-m-d', $op->getOperationDate()->sec),
                    ];
                }
                $price_assurence =0;
                $price_vidange =0;
                $price_vignette =0;
                $price_entretien =0;
                $price_reparation =0;
                foreach ($operat as $al){
                    if($al['type'] =="assurence"){
                        $price_assurence =$price_assurence+$al['price'];
                    }
                    elseif($al['type']=="vidange"){
                        $price_vidange =$price_vidange+$al['price'];
                    }
                    elseif($al['type']=="vignette"){
                        $price_vignette =$price_vignette+$al['price'];
                    }
                    elseif($al['type']=="entretien"){
                        $price_entretien =$price_entretien+$al['price'];
                    }
                    else{
                        $price_reparation =$price_reparation+$al['price'];
                    }
                }
                if($price_reparation+$price_entretien+$price_vignette+$price_vidange+$price_assurence>0){
                    $formatted[]=[
                        'reg_number'=>$result->getRegNumber(),
                        'assurence'=>$price_assurence,
                        'vidange'=>$price_vidange,
                        'vignette'=>$price_vignette,
                        'entretien'=>$price_entretien,
                        'reparation'=>$price_reparation,
                        'total'=>$price_reparation+$price_entretien+$price_vignette+$price_vidange+$price_assurence,
                    ];
                }
                $datearrayu=array_unique($datearray);
                $ope1=array();
            }

        }
        return $formatted;
        //return "aaaa";
    }
    /**
     * @Rest\Get("/myflotdashh/{id}/{date}",name="hfgekoooodkdalfh")
     * @param Request $request
     * @return view
     */
    public function getmyrealVehiclesdateAction(Request $request)
    {
        //var_dump("ssssfsds");die();
        $id = $request->get('id');
        $date = $request->get('date');
        $date=date('Y-m',strtotime($date));
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
                unset($operat);
                $datearray=array();
                foreach ($result->getOperations() as $op){
                    if($date==date('Y-m', $op->getOperationDate()->sec)){
                        array_push($datearray,date('Y-m-d', $op->getOperationDate()->sec));
                        $operat[] = [
                            'id' => $op->getId(),
                            'libele' => $op->getLibelle(),
                            'type' => $op->getType(),
                            'price' => $op->getPrice(),
                            'operation_date' => date('Y-m-d', $op->getOperationDate()->sec),
                        ];
                    }

                }
                $price_assurence =0;
                $price_vidange =0;
                $price_vignette =0;
                $price_entretien =0;
                $price_reparation =0;
                foreach ($operat as $al){
                    if($al['type'] =="assurence"){
                        $price_assurence =$price_assurence+$al['price'];
                    }
                    elseif($al['type']=="vidange"){
                        $price_vidange =$price_vidange+$al['price'];
                    }
                    elseif($al['type']=="vignette"){
                        $price_vignette =$price_vignette+$al['price'];
                    }
                    elseif($al['type']=="entretien"){
                        $price_entretien =$price_entretien+$al['price'];
                    }
                    else{
                        $price_reparation =$price_reparation+$al['price'];
                    }
                }
                if($price_reparation+$price_entretien+$price_vignette+$price_vidange+$price_assurence>0){
                    $formatted[]=[
                        'reg_number'=>$result->getRegNumber(),
                        'assurence'=>$price_assurence,
                        'vidange'=>$price_vidange,
                        'vignette'=>$price_vignette,
                        'entretien'=>$price_entretien,
                        'reparation'=>$price_reparation,
                        'total'=>$price_reparation+$price_entretien+$price_vignette+$price_vidange+$price_assurence,
                    ];
                }

                $datearrayu=array_unique($datearray);
                $ope1=array();
            }

        }
        //return $operat;
        return $formatted;
        //return "aaaa";
    }
}
