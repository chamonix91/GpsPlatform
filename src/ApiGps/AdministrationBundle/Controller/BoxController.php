<?php

namespace ApiGps\AdministrationBundle\Controller;


use ApiGps\AdministrationBundle\Document\Box;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
class BoxController extends  FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /////////////////////////////
    ///// get all Boxes /// /////
    /// /////////////////////////

    /**
     * @Rest\Get("/box")
     */
    public function getBoxAction()
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->findAll();
        if ($result === null) {
            return new View("there are no boxes exist", Response::HTTP_NOT_FOUND);
        }


        return $result;
    }
    /////////////////////////////
    ///// get Box by id /// /////
    /// /////////////////////////
    /**
     * @Rest\Get("/box/{id}")
     * @param $id
     * @return View|null|object
     */
    public function idBoxAction($id)
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($id);
        if ($result === null) {
            return new View("box not found", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /////////////////////////////
    ///// Add Box////////// /////
    /// /////////////////////////
    /**
     * @Rest\Post("/box")
     * @param Request $request
     * @return string
     */
    public function postBoxAction(Request $request)
    {
        $data = new Box();
        $IMEI = $request->get('imei');
        $ass_sim = $request->get('ass_sim');
        $client_sim = $request->get('client_sim');
        $buy_date = strtotime(substr($request->get('buy_date'),0,24));
        $bond_date = strtotime(substr($request->get('bond_date'),0,24));
        $endbond_date = strtotime(substr($request->get('endbond_date'),0,24));
        $mark = $request->get('mark');
        $model = $request->get('model');
        $type = $request->get('type');
        $idcompany = $request->get('idcompany');

        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
        //$active = $request->get('active');
        $retrait_date = strtotime(substr($request->get('retrait_date'),0,24));


        if( empty($IMEI))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setEndbondDate($endbond_date);
        $data->setRetraitDate($retrait_date);
        $data->setModel($model);
        $data->setMark($mark);
        $data->setImei($IMEI);
        $data->setActive(true);
        $data->setType($type);
        $data->setAssSim($ass_sim);
        $data->setBondDate($bond_date);
        $data->setClientSim($client_sim);
        $data->setBuyDate($buy_date);
        $data->setCompany($company);
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("Box Added Successfully", Response::HTTP_OK);
    }

    /////////////////////////////
    ///// Update Box ////////////
    /// /////////////////////////


    /**
     * @Rest\Put("/box/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updateBoxAction($id,Request $request)
    {
        $numTel = $request->get('client_sim');
        $IMEI = $request->get('imei');
        $ass_sim = $request->get('ass_sim');
        $client_sim = $request->get('client_sim');
        $buy_date = strtotime(substr($request->get('buy_date'),0,24));
        $mark = $request->get('mark');
        $model = $request->get('model');
        $type = $request->get('type');
        $retrait_date = strtotime(substr($request->get('retrait_date'),0,24));
        $idcompany = $request->get('idcompany');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($id);
        if (empty($boitier)) {
            return new View("box not found", Response::HTTP_NOT_FOUND);

        }

        $boitier->setRetraitDate($retrait_date);
        $boitier->setModel($model);
        $boitier->setMark($mark);
        $boitier->setActive(true);
        $boitier->setType($type);
        $boitier->setAssSim($ass_sim);
        $boitier->setBuyDate($buy_date);
        $boitier->setClientSim($numTel);
        $boitier->setImei($IMEI);
        $boitier->setCompany($company);
        $sn->flush();
        return new View("box Updated Successfully", Response::HTTP_OK);


    }

    //////////////////////////////
    ////////  Get My Box  ////////
    //////////////////////////////

    /**
     * @Rest\Get("/box/{id}/")
     * @param Request $request
     * @return Box[]|array|View
     */
    public function getMyBoxesAction(Request $request)
    {
        $id = $request->get('id');

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        $mycompany = $user->getCompany();
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->findBy(array('company'=>$mycompany));

        //dump($results);die();

        if ($results === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }


        return $results;
    }

    //////////////////////////////
    ////////  Bound  Box  ////////
    //////////////////////////////

    /**
     * @Rest\Put("/bondbox/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function BondBoxAction($id,Request $request)
    {
        $bond_date = strtotime(substr($request->get('bond_date'),0,24));
        $idVehicle = $request->get('idvehicle');
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idVehicle);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($id);
        if (empty($boitier)) {
            return new View("box not found", Response::HTTP_NOT_FOUND);

        }


        $boitier->setBondDate($bond_date);
        $boitier->setVehicle($vehicle);
        $boitier->setEndbondDate(null);
        $sn->flush();
        return new View("box Updated Successfully", Response::HTTP_OK);


    }

    //////////////////////////////
    ////////  UnBond  Box  ////////
    //////////////////////////////

    /**
     * @Rest\Put("/unbondbox/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function EndBondBoxAction($id,Request $request)
    {
        $endbond_date = strtotime(substr($request->get('endbond_date'),0,24));
        $idVehicle = $request->get('idvehicle');
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idVehicle);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($id);
        if (empty($boitier)) {
            return new View("box not found", Response::HTTP_NOT_FOUND);

        }


        $boitier->setEndbondDate($endbond_date);
        $boitier->setVehicle($vehicle);
        $boitier->setBondDate(null);
        $sn->flush();
        return new View("box Updated Successfully", Response::HTTP_OK);


    }








}
