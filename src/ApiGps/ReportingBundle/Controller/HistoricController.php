<?php

namespace ApiGps\ReportingBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class HistoricController extends FOSRestController
{

    /**
     * @Rest\Get("/historic/{id}/{startdate}/{enddate}/")
     */
    public function getTramesBydateAction(Request $request)
    {

        $id = $request->get('id');
        $startdate = $request->get('startdate');
        $enddate = $request->get('startdate');

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($id);

        $company = $user->getCompany();

        $fleets = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:fleet')
            ->findBy(array('company'=>$company));
        if ($fleets === null) {
            return new View("there are no fleets exist", Response::HTTP_NOT_FOUND);
        }

        //$vehicles= array();
        $trames = array();

        foreach ($fleets as $fleet){

            $vehicles = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
                ->findBy(array('fleet'=>$fleet));

            foreach ($vehicles as $vehicle){
                array_push($trames,$vehicle->getBox()->getTrame());
            }


        }

        $resTrame=array();
        $i = 0;
        for ($j = 0; $j < count($trames); $j++) {

            if ((date('Y-m-d', $trames[$j]->getTimestamp()) > $startdate) &&
                (date('Y-m-d', $trames[$j]->getTimestamp()) < $enddate)) {
                $resTrame[$i] = $trames[$j];
                $i++;
            }
        }

        for ($k=0;$k<count($resTrame);$k++){
            $result[]=[
                'reg_number' => $resTrame[$k]->getBox()->getVehicle()->getRegNumber(),
                'timestamp' => date('Y-m-d H:i:s',$resTrame[$k]->getTimeStamp()) ,
                'longitude' => $resTrame[$k]->getLongitude(),
                'latitude' => $resTrame[$k]->getLatitude(),
            ];

        }


        return $result;
    }
}
