<?php

namespace ApiGps\EspaceUserBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/ss/{token}", name="oth")
     * @param Request $request
     */
    public function getSessionAction(Request $request)
    {

        $id = $request->get('token');
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:RefreshToken')
            ->findOneBytoken($id);
        $user = $this->get('doctrine_mongodb')
            ->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($result->getUser()->getId());
        return $user;
        //return $user->getId();
    }
    /**
     * @Rest\Post("/ss", name="oth")
     * @param Request $request
     */
    public function posSessionAction(Request $request)
    {

//var_dump('aaaaa');die();
        return 'aaaaa';
        //return $user->getId();
    }

}
