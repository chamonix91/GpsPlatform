<?php

namespace ApiGps\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FleetController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


}
