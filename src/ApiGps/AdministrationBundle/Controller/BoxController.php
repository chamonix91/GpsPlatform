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
        $numTel = $request->get('phone_num');
        $IMEI = $request->get('imei');



        if(empty($numTel) || empty($IMEI))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setPhoneNum($numTel);
        $data->setImei($IMEI);
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
        $numTel = $request->get('phone_num');
        $IMEI = $request->get('imei');
        $sn = $this->get('doctrine_mongodb')->getManager();
        $boitier = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($id);
        if (empty($boitier)) {
            return new View("box not found", Response::HTTP_NOT_FOUND);

        }
        $boitier->setPhoneNum($numTel);
        $boitier->setImei($IMEI);
        $sn->flush();
        return new View("box Updated Successfully", Response::HTTP_OK);


    }
}
