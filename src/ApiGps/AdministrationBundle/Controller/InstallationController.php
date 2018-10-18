<?php

namespace ApiGps\AdministrationBundle\Controller;


use ApiGps\AdministrationBundle\Document\Installation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class InstallationController extends  FOSRestController
{

    /////////////////////////////
    ///// Add installation  /////
    /////////////////////////////
    /**
     * @Rest\Post("/installation")
     * @param Request $request
     * @return string
     */
    public function postInstallationAction(Request $request)
    {
        $data = new Installation();

        $idbox = $request->get('idbox');
        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');


        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idbox);
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $installateur = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($idinstallateur);


        if( empty($idbox) || empty($idvehicle) || empty($idinstallateur))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setBox($box);
        $data->setVehicle($vehicle);
        $data->setInstallateur($installateur);

        $vehicle->setBox($box);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->persist($vehicle);
        $em->flush();

        return new View("installation Added Successfully", Response::HTTP_OK);
    }

    /////////////////////////////
    ///// Modify installation  /////
    /////////////////////////////

    /**
     * @Rest\Put("/installation/{id}")
     * @param Request $request
     * @return string
     */
    public function modifyInstallationAction(Request $request)
    {
        $data = new Installation();

        $idbox = $request->get('idbox');
        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');


        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idbox);
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $installateur = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($idinstallateur);

        $data = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Installation')->find($id);



        if( empty($idbox) || empty($idvehicle) || empty($idinstallateur))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }

        if ($data->getVehicle() == $vehicle){

            $vehicle->setBox($box);

            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($vehicle);


        }

        if ($data->getBox() == $box){

            $box->setVehicle($vehicle);

            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($vehicle);


        }

        $data->setBox($box);
        $data->setVehicle($vehicle);
        $data->setInstallateur($installateur);

        $vehicle->setBox($box);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->persist($vehicle);
        $em->flush();

        return new View("installation updated Successfully", Response::HTTP_OK);
    }

}
