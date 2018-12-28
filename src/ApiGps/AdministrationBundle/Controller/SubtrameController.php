<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Trame;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class SubtrameController extends FOSRestController
{
    /**
     * @Rest\Get("/sutrame")
     */
    public function getTrameAction()
    {

        return "hello node js";
    }
}
