<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Subscription;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SubscriptionController extends  FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    //////////////////////////////////
    ///// get all subscriptions //////
    //////////////////////////////////

    /**
     * @Rest\Get("/sub")
     */
    public function getSubAction()
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Subscription')->findAll();
        if ($result === null) {
            return new View("there are no subscriptions exist", Response::HTTP_NOT_FOUND);
        }


        return $result;
    }

    /////////////////////////////
    ///// get sub by id /// /////
    /// /////////////////////////
    /**
     * @Rest\Get("/sub/{id}")
     * @param $id
     * @return View|null|object
     */
    public function idBoxAction($id)
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Subscription')->find($id);
        if ($result === null) {
            return new View("Subscription not found", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /////////////////////////////
    ///// Add Sub////////// /////
    /// /////////////////////////
    /**
     * @Rest\Post("/sub")
     * @param Request $request
     * @return string
     */
    public function postSubAction(Request $request)
    {
        $data = new Subscription();
        $subtype = $request->get('subtype');
        $start_date = strtotime(substr($request->get('start_date'),0,24));
        $end_date = strtotime(substr($request->get('end_date'),0,24));

        $idcompany = $request->get('idcompany');
        $idbox = $request->get('idbox');

        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idbox);
        //$active = $request->get('active');


        if( empty($idbox) && empty($idcompany))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setSubType($subtype);
        $data->setStartDate($start_date);
        $data->setEndDate($end_date);
        $data->setCompany($company);
        $data->setBox($box);
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("Subscription Added Successfully", Response::HTTP_OK);
    }


    //////////////////////////////////////
    ///// Update Subscription ////////////
    //////////////////////////////////////


    /**
     * @Rest\Put("/sub/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updateSubAction($id,Request $request)
    {

        $subtype = $request->get('subtype');
        $start_date = strtotime(substr($request->get('start_date'),0,24));
        $end_date = strtotime(substr($request->get('end_date'),0,24));

        $idcompany = $request->get('idcompany');
        $idbox = $request->get('idbox');

        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idbox);

        $data = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Subscription')->find($id);


        $sn = $this->get('doctrine_mongodb')->getManager();

        if( empty($idbox) && empty($idcompany))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }



        $data->setSubType($subtype);
        $data->setStartDate($start_date);
        $data->setEndDate($end_date);
        $data->setCompany($company);
        $data->setBox($box);


        $sn->flush();
        return new View("Subscription Updated Successfully", Response::HTTP_OK);


    }
}
