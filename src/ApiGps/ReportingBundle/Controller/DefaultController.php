<?php

namespace ApiGps\ReportingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApiGpsReportingBundle:Default:index.html.twig');
    }
}
