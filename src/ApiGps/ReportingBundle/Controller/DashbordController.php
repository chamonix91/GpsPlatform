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
                    if ((date('Y-m-d', $trames[$j]->getTimestamp()) >= $d2) &&
                        (date('Y-m-d', $trames[$j]->getTimestamp()) <= $d1)) {
                        var_dump((date('Y-m-d', $trames[$j]->getTimestamp()) ));
                        var_dump((date('Y-m-d', $trames[$j]->getTimestamp()) >= $d2 ));
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
                    'last' => date('Y-m-d',$x[$i]->getTrame()[count($x[$i]->getTrame())-1]->getTimestamp()),
                ];
                array_push($final,$formatted);
            }
            }

        //}
        return ($final);
    }

}
