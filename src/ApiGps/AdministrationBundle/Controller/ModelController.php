<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Model;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class ModelController extends  FOSRestController
{


    /////////////////////////////
    /////   Get all models  /////
    /////////////////////////////

    /**
     * @Rest\Get("/model")
     */
    public function getModelAction()
    {
        $models = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Model')->findAll();
        if ($models === null) {
            return new View("there are no models exist", Response::HTTP_NOT_FOUND);
        }
        foreach ($models as $company) {
            $formatted[] = [
                'id' => $company->getId(),
                'name'=>$company->getName(),
                'mark'=>$company->getMark()->getName(),
            ];
        }
        return $formatted;
    }

    //////////////////////////
    /////     Add Model  /////
    //////////////////////////

    /**
     * @Rest\Post("/model/")
     * @param Request $request
     * @return View
     */
    public function postModelAction(Request $request)
    {
        $data = new Model();
        $name = $request->get('name');
        $idmark = $request->get('idmark');
        $mark = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Mark')->find($idmark);

        if(empty($name) || empty($idmark))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setName($name);
        $data->setMark($mark);
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        $result = new View("model Added Successfully", Response::HTTP_OK);
        return $result;
    }

}
