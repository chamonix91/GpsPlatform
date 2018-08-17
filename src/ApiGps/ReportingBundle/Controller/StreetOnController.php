<?php

namespace ApiGps\ReportingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StreetOnController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
