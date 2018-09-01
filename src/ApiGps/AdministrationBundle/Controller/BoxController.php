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
    ///// get my Boxes /// /////
    /// /////////////////////////

    /**
     * @Rest\Get("/box/{id}")
     */
    public function getmyBoxAction(Request $request)
    {
        $id = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($id);

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->findby(array('company'=>$company));
        //var_dump($result);die();
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
        $sn = $this->get('doctrine_mongodb')->getManager();
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($id);
        if (empty($boitier)) {
            return new View("box not found", Response::HTTP_NOT_FOUND);

        }

        $boitier->setModel($model);
        $boitier->setMark($mark);
        $boitier->setActive(true);
        $boitier->setType($type);
        $boitier->setAssSim($ass_sim);
        $boitier->setBuyDate($buy_date);
        $boitier->setClientSim($numTel);
        $boitier->setImei($IMEI);
        $sn->flush();
        return new View("box Updated Successfully", Response::HTTP_OK);


    }
}
