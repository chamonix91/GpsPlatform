<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApiGpsAdministrationBundle:Default:index.html.twig');
    }

    public function createAction()
    {
        $vehicle = new Vehicle();
        $vehicle->setRegNumber('a3ehhehehhe333');

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($vehicle);
        $dm->flush();

        return new Response('Success ');
    }
}
