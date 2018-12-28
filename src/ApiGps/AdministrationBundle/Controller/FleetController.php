<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\fleet;
use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class FleetController extends FOSRestController
{
    /////////////////////////////
    /////   Get all fleet   /////
    /////////////////////////////

    /**
     * @Rest\Get("/fleet")
     */
    public function getFleetAction()
    {
        $fleets = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->findAll();
        //var_dump($fleets);die();
        if ($fleets === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }

        return $fleets;
    }


    /////////////////////////////
    /////   Get my fleets   /////
    /////////////////////////////

    /**
     * @Rest\Get("/fleet/{id}")
     */
    public function getMyFleetsAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);;
        $mycompany = $user->getCompany();
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findAll();

        if ($results === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }


        foreach ($results as $fleet) {
            if ($fleet->getComapny() == $mycompany){
                $company = [
                    'id' => $user->getCompany()->getId(),
                    'cp_name' => $user->getCompany()->getCpName(),
                ];

                for($o=0;$o<count($fleet->getVehicles());$o++){
                    $fleet->getVehicles()[$o]->setInsurance(date('Y-m-d',$fleet->getVehicles()[$o]->getInsurance()->sec));
                    $fleet->getVehicles()[$o]->setVignettes(date('Y-m-d',$fleet->getVehicles()[$o]->getVignettes()->sec));
                    $fleet->getVehicles()[$o]->setTechnicalVisit(date('Y-m-d',$fleet->getVehicles()[$o]->getTechnicalVisit()->sec));
                }
            if (!empty($fleet->getVehicles() && !empty($fleet->getComapny())) ){
                $formatted[] = [
                    'id' => $fleet->getId(),
                    'taille' => $company,
                    'name' => $fleet->getName(),
                    'companyname' => $fleet->getComapny()->getName(),
                    'vehicles' => count($fleet->getVehicles()),

                ];
            }
            elseif(empty($fleet->getVehicles())){
                $formatted[] = [
                    'id' => $fleet->getId(),
                    'taille' => $company,
                    'name' => $fleet->getName(),
                    'companyname' => $fleet->getComapny()->getName(),
                    'vehicles' => "aucune voiture ajoutée à cette flotte",

                ];

            }
            }


        }
        return $formatted;
    }
    /**
     * @Rest\Get("/nbrfleet/{id}")
     */
    public function getnbrFleetsAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);;
        $mycompany = $user->getCompany();
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findAll();

        if ($results === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }

        $x=0;
        foreach ($results as $fleet) {
            if ($fleet->getComapny() == $mycompany) {

                $x++;

            }

        }
        return $x;
    }
    ///////////////////////////////////////
    /////     Add fleet SuperAdmin    /////
    ///////////////////////////////////////

    /**
     * @Rest\Post("/fleet")
     * @param Request $request
     * @return string
     */
    public function postFleetAction(Request $request)
    {
        $data = new fleet();
        $name = $request->get('name');
        $vehicles = $request->get('vehicles');
        $idcompany = $request->get('idcompany');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);

        if (empty($name)  ) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setName($name);

        $a = json_decode(json_encode($vehicles),true);
        if ($vehicles != 'null' || $vehicles != null || !empty($vehicles)) {
            $tab_vehicle = (array)new Vehicle();
            for ($c = 0; $c < count($a); $c++) {
                $tmp = $this->get('doctrine_mongodb')
                    ->getRepository('ApiGpsAdministrationBundle:Vehicle')
                    ->find($a[$c]);
                array_push($tab_vehicle, $tmp);
                $data->addVehicle($tmp);
            }
        }


            $data->setComapny($company);

            //dump($data);die();

            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($data);
            $em->flush();
            return new View("fleet added Successfully", Response::HTTP_OK);

    }

    /////////////////////////////////////////
    /////     Add fleet OperatorAdmin   /////
    /////////////////////////////////////////

    /**
     * @Rest\Post("/myfleet/{id}")
     * @param Request $request
     * @return string
     */
    public function postMyFleetAction(Request $request)
    {
        $id = $request->get('id');

        $data = new fleet();
        $name = $request->get('name');
        $vehicles = $request->get('vehicles');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($id);
        //dump($company);die();

        if (empty($name) || empty($vehicles) || empty($idcompany) ) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setName($name);

        $a = json_decode(json_encode($vehicles),true);
        if ($vehicles != 'null' || $vehicles != null || !empty($vehicles)) {
            $tab_vehicle = (array)new Vehicle();
            for ($c = 0; $c < count($a); $c++) {
                $tmp = $this->get('doctrine_mongodb')
                    ->getRepository('ApiGpsAdministrationBundle:Vehicle')
                    ->find($a[$c]);
                array_push($tab_vehicle, $tmp);
                $data->addVehicle($tmp);
            }
        }


        $data->setComapny($company);

        //dump($data);die();

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("fleet added Successfully", Response::HTTP_OK);



    }

    ///////////////////////////////////////
    /////   update fleets superadmin  /////
    ///////////////////////////////////////

    /**
     * @Rest\Put("/fleet/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updateFleetAction($id,Request $request)
    {
        $name = $request->get('name');
        $idcompany = $request->get('idcompany');
        $vehicles = $request->get('idvehicle');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $fleet = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->find($id);

        if (empty($fleet)) {
            return new View("fleet not found", Response::HTTP_NOT_ACCEPTABLE);
        }

        $fleet->setName($name);
        $fleet->setComapny($company);
        if (empty($name) || empty($vehicles) || empty($idcompany) ) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }


        $a = json_decode(json_encode($vehicles),true);
        if ($vehicles != 'null' || $vehicles != null || !empty($vehicles)) {
            $tab_vehicle = (array)new Vehicle();
            for ($c = 0; $c < count($a); $c++) {
                $tmp = $this->get('doctrine_mongodb')
                    ->getRepository('ApiGpsAdministrationBundle:Vehicle')
                    ->find($a[$c]);
                array_push($tab_vehicle, $tmp);
                $fleet->addVehicle($tmp);
            }
        }

        $sn->flush();
        return new View("fleet Updated Successfully", Response::HTTP_OK);
    }

    //////////////////////////////////////////
    /////   update fleets Operatoradmin  /////
    //////////////////////////////////////////

    /**
     * @Rest\Put("/fleet/{id}/{iduser}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updateMyFleetAction($id,Request $request)
    {

        $name = $request->get('name');
        $vehicles = $request->get('idvehicle');
        $sn = $this->get('doctrine_mongodb')->getManager();
        $fleet = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->find($id);

        if (empty($fleet)) {
            return new View("fleet not found", Response::HTTP_NOT_ACCEPTABLE);
        }

        $fleet->setName($name);
        if (empty($name)   ) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }


        $a = json_decode(json_encode($vehicles),true);
        if ($vehicles != 'null' || $vehicles != null || !empty($vehicles)) {
            $tab_vehicle = (array)new Vehicle();
            for ($c = 0; $c < count($a); $c++) {
                $tmp = $this->get('doctrine_mongodb')
                    ->getRepository('ApiGpsAdministrationBundle:Vehicle')
                    ->find($a[$c]);
                array_push($tab_vehicle, $tmp);
                $fleet->addVehicle($tmp);
            }
        }

        $sn->flush();
        return new View("fleet Updated Successfully", Response::HTTP_OK);
    }

    ///////////////////////////////////////
    /////       Get fleet By Id       /////
    ///////////////////////////////////////


    /**
     * @Rest\Get("/fleet/{id}/")
     */
    public function GetFleetByIdAction($id)
    {
        $fleet = $this->getDoctrine()->getRepository('ApiGpsAdministrationBundle:fleet')->find($id);
        if ($fleet === null) {
            return new View("fleet not found", Response::HTTP_NOT_FOUND);
        }
        /*foreach ($fleet as $user) {
            var_dump($user->getVehicles()->getBox()->getTrame());die();
            $user->getVehicles()->getBox()->setTrame(null);
            $user->getComapny()->setBoxes(null);
        }
        var_dump($fleet[0]);die();*/
        return $fleet;
    }
    public function idBoxval($id,$a)
    {

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($id);
        if ($result === null) {
            return null;
        }

        $formatted = [
            'imei' => $result->getId(),
            'mark' => $result->getMark(),
            'model' => $result->getModel(),
            'type' => $result->getType(),
            'ass_sim' => $result->getAssSim(),
            'client_sim' => $result->getClientSim(),
            'active' => $result->getActive(),
            //'trame' => $a,

        ];

        return $formatted;
    }
    public function idBoxtrames($id)
    {

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Trame')
            ->findBy(array('box'=>$id));
        if ($result === null) {
            return null;
        }
        foreach ($result as $user) {
            $formatted[] = [
                'id' => $user->getId(),
                'timestamp' => $user->getTimestamp(),
                'longitude' => $user->getLongitude(),
                'latitude' => $user->getLatitude(),
                'angle' => $user->getAngle(),
                'speed' => $user->getSpeed(),
                'contact' => $user->getContact(),
                'box' => $user->getBox()->getImei(),

            ];
        }
        if(count($result)==0)
            return null;
        else
            return $formatted;
    }

    /**
     * @Rest\Get("/fleett",name="no asoo")
     */
    public function GetFleetBynorefIdAction()
    {
        $fleets = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->findAll();
        //var_dump($fleets);die();
        if ($fleets === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }
        $formatted1= array();
        foreach ($fleets as $user) {


            //$formatted2[] = [];
            //if ($user->getBox()->getCompany()->getId() == "5be74a4413cf753d698b4567") {
                foreach ($user->getVehicles() as $result) {

                    if(!empty($result->getBox()) || $result->getBox() != null){


                        $trams=$this->idBoxtrames($result->getBox());
                        $box=$this->idBoxval($result->getBox()->getId(),$trams);

                    }
                    else{
                        $box=null;
                    }

                    $formatted1[] = [
                        'reg_number' => $result->getRegNumber(),
                        'box' => $box,
                        'flot' => $result->getFlot()->getId(),
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
                    //
                    //var_dump(count($formatted1));
                }
               // var_dump($user->getComapny()->getId());die();
            $company =$user->getComapny();
                $formatted2 = [
                    'id' => $company->getId(),
                    'name'=>$company->getName(),
                    'adress'=>$company->getAdress(),
                    'phone'=>$company->getPhone(),
                    'created_date'=>$company->getCreatedDate(),
                    'end_date'=>strtotime($company->getEndDate()),
                    'cp_name'=>$company->getCpName(),
                    'cp_phone'=>$company->getCpPhone(),
                    'cpa_name'=>$company->getCpaName(),
                    'cpa_phone'=>$company->getCpaPhone(),
                ];

                $formatted[] = [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'vehicles' => $formatted1,
                    'comapny' => $formatted2,

                ];
            $formatted1 = array();
            }
       // }
return $formatted;
    }
    /////////////////////////////
    /////   Get my fleets no affected   /////
    /////////////////////////////
    /**
     * @Rest\Get("/fleetaffect")
     */
    public function getnoaffectedFleetAction()
    {
        $fleets = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->findAll();
        //var_dump($fleets);die();
        if ($fleets === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }

        foreach ($fleets as $fleet) {

            if (!empty($fleet->getComapny()) ){
                $formatted[] = [
                    'name' => $fleet->getName(),
                    'companyname' => $fleet->getComapny()->getName(),
                    'vehicles' => count($fleet->getVehicles()),

                ];
            }



        }
        return $formatted;
    }


}
