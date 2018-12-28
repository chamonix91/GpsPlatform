<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\fleet;
use ApiGps\AdministrationBundle\Document\Ioelement;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class IoelementController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/allio")
     */
    public function getIoAction()
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Ioelement')->findAll();
        if ($result === null) {
            return new View("there are no boxes exist", Response::HTTP_NOT_FOUND);
        }


        foreach ($result as $fleet) {
            $formatted[] = [
                'id' => $fleet->getId(),
                'idio' => $fleet->getIdio(),
                'designation' => $fleet->getDesignation(),
                'label' => $fleet->getLabel(),

            ];

        }
        if(count($formatted)==0)
            return null;
        else
            return $formatted;
    }

    /**
     * @Rest\Post("/allio")
     * @param Request $request
     * @return string
     */
    public function postIoAction(Request $request)
    {
        $data = new Ioelement();
        $idio = $request->get('idio');
        $designation = $request->get('designation');
        $label = $request->get('label');

        $data->setIdio($idio);
        $data->setDesignation($designation);
        $data->setLabel($label);


        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("Box Added Successfully", Response::HTTP_OK);
    }
}
