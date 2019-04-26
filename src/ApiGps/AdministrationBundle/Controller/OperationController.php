<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Operation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class OperationController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/operation",name="alooo")
     */
    public function getOperationsAction()
    {
        //var_dump("sssss");die();
        $results = $this->get('doctrine_mongodb')->getRepository
        ('ApiGpsAdministrationBundle:Operation')->findAll();
        //dump($restresult);die();
        if ($results === null) {
            return new View("there are no alert exist", Response::HTTP_NOT_FOUND);
        }

        foreach ($results as $result) {



                $drivers[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibelle(),
                    'type' => $result->getType(),
                    'price' => $result->getPrice(),
                    'operation_date' => date('Y-m-d', $result->getOperationDate()->sec),
                ];


        }
        return $drivers;
    }
    /**
     * @Rest\Get("/operation/{id}/",name="sw")
     */
    public function getOperationsbycompanyAction(Request $request)
    {
       // var_dump("dddddd");die();
        $id = $request->get('id');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        $results = $this->get('doctrine_mongodb')->getRepository
        ('ApiGpsAdministrationBundle:Operation')
            ->findBy(array('company' => $user->getCompany()));
        //dump($restresult);die();
        if ($results === null) {
            return new View("there are no alert exist", Response::HTTP_NOT_FOUND);
        }


        foreach ($results as $result) {



            $drivers[] = [
                'id' => $result->getId(),
                'libele' => $result->getLibelle(),
                'type' => $result->getType(),
                'price' => $result->getPrice(),
                'operation_date' => date('Y-m-d', $result->getOperationDate()->sec),
            ];


        }
        return $drivers;
    }

    /**
     * @Rest\Post("/operation/{id}")
     * @param Request $request
     * @return string
     */
    public function postOperationAction(Request $request)
    {


        $data = new Operation();

        $libelle = $request->get('libelle');
        $type = $request->get('type');
        $price = $request->get('price');
        $operation_date = $request->get('operation_date');
        $idcompany = $request->get('idcompany');

        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);


        if(empty($libelle)|| empty($type) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibelle($libelle);
        $data ->setType($type);
        $data ->setPrice($price);
        $data->setActive(true);
        $data->setOperationDate(strtotime($operation_date));
        if(!empty($company))
            $data->setCompany($company);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Alert added Successfully", Response::HTTP_OK);


    }
    /**
     * @Rest\Post("/operation",name="adding")
     * @param Request $request
     * @return string
     */
    public function postOperationadminAction(Request $request)
    {
    //var_dump("sdsfsds");die();
        $data = new Operation();

        $libelle = $request->get('libelle');
        $type = $request->get('type');
        $price = $request->get('prix');
        $operation_date = $request->get('operation_date');
        $idcompany = $request->get('idcompany');

        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);


        if(empty($libelle)|| empty($type) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data ->setLibelle($libelle);
        $data ->setType($type);
        $data ->setPrice($price);
        $data->setActive(true);
        $data->setOperationDate(strtotime($operation_date));
        if(!empty($company))
            $data->setCompany($company);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Alert added Successfully", Response::HTTP_OK);


    }

    /**
     * @Rest\Put("/affectoperationtoobject/{id}",name="juju")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function AffecttoojectAlertAction($id,Request $request)
    {


        $operation = $this->get('doctrine_mongodb')->getRepository
        ('ApiGpsAdministrationBundle:Operation')->find($id);
        $idobject = $request->get('idobject');

        $object = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->find($idobject);
        $idclient = $request->get('idclient');
        $client = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')
            ->find($idclient);
        $sn = $this->get('doctrine_mongodb')->getManager();

        $operation->setActive(true);
        $operation->setVehicle($object);
        //$operation->setCompany($client);
        $sn->merge($operation);
        $sn->flush();
        return new View("alert activated Successfully", Response::HTTP_OK);


    }
}
