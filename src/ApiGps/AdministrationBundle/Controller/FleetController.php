<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\fleet;
use ApiGps\AdministrationBundle\Document\Vehicle;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class FleetController extends Controller
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

        foreach ($fleets as $fleet) {

            if (!empty($fleet->getVehicles() && !empty($fleet->getComapny())) ){
            $formatted[] = [
                'name' => $fleet->getName(),
                'companyname' => $fleet->getComapny()->getName(),
                'vehicles' => $fleet->getVehicles(),

            ];
        }
            elseif(empty($fleet->getVehicles())){
                $formatted[] = [
                    'name' => $fleet->getName(),
                    'companyname' => $fleet->getComapny()->getName(),
                    'vehicles' => "aucune voiture ajoutée à cette compagne",

                ];

            }


        }
        return $formatted;
    }

    /////////////////////////////
    /////   Get my fleets   /////
    /////////////////////////////

    /**
     * @Rest\Get("/fleet")
     */
    public function getMyFleetsAction()
    {
        $fleets = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')->findAll();
        //var_dump($fleets);die();
        if ($fleets === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }

        foreach ($fleets as $fleet) {

            if (!empty($fleet->getVehicles() && !empty($fleet->getComapny())) ){
                $formatted[] = [
                    'name' => $fleet->getName(),
                    'companyname' => $fleet->getComapny()->getName(),
                    'vehicles' => $fleet->getVehicles(),

                ];
            }
            elseif(empty($fleet->getVehicles())){
                $formatted[] = [
                    'name' => $fleet->getName(),
                    'companyname' => $fleet->getComapny()->getName(),
                    'vehicles' => "aucune voiture ajoutée à cette compagne",

                ];

            }


        }
        return $formatted;
    }

    ///////////////////////////////////////
    /////     Add fleet SuperAdmin   /////
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


            $data->setComapny($company);

            //dump($data);die();

            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($data);
            $em->flush();
            return new View("fleet added Successfully", Response::HTTP_OK);


        }
    }

}
