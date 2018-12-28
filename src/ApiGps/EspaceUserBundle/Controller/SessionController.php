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
        if (!empty($user->getCompany()) || $user->getCompany() != null){
            $company = [
                'id' => $user->getCompany()->getId(),
                'cp_name' => $user->getCompany()->getCpName(),
                ];
            $formatted = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'last_name' => $user->getLastName(),
                'first_name' => $user->getFirstName(),
                'phone' => $user->getPhone(),
                'enabled' => $user->isEnabled(),
                'company' => $company,
                'roles' => $user->getRoles()[0],

            ];
        }
        else{
            $formatted = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'last_name' => $user->getLastName(),
                'first_name' => $user->getFirstName(),
                'phone' => $user->getPhone(),
                'enabled' => $user->isEnabled(),
                'roles' => $user->getRoles()[0],

            ];
        }
        if($user===null)
            return null;
        else
            //var_dump('hh');die();
            return $formatted;
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
