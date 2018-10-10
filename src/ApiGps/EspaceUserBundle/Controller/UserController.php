<?php

namespace ApiGps\EspaceUserBundle\Controller;

use ApiGps\EspaceUserBundle\Document\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class UserController extends FOSRestController
{
    /////////////////////////////
    /////    Create User    /////
    /////////////////////////////

    /**
     * @Rest\Post("/user/{id}")
     * @param Request $request
     * @return View
     */
    public function addUserAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $phone = $request->get('phone');

        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $plainpassword = $request->get('plainpassword');
        $roles = $request->get('roles');

        if(empty($username) || empty($email)|| empty($password))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = $userManager->createUser();
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($id);

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(true);
        /*$user->setPassword($password);
        $user->setPlainPassword($plainpassword);*/

        $user->setFirstName($first_name);
        $user->setLastName($last_name);
        $user->setPhone($phone);
        $user->setCompany($company);
        $user->setRoles(array($roles));



        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($user);
        $em->flush();
        return new View("User Added Successfully", Response::HTTP_OK);
 }

    /////////////////////////////
    /////  Get all Users   /////
    /////////////////////////////

    /**
     * @Rest\Get("/user")
     */
    public function getUsersAction()
    {
        $users = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->findAll();
        if ($users === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $users;
    }


    ///////////////////////////////////////
    /////  Get all Users By Company   /////
    ///////////////////////////////////////

    /**
     * @Rest\Get("/myusers/{id}")
     * @param Request $request
     * @return array|View
     */
    public function getUsersByCompanyAction(Request $request)
    {

        $idcompany = $request->get('id');

        $users = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->findAll();
        $myusers = array();

        foreach ( $users as $user){

            $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
            if ($user->getCompany()== $company){
                array_push($myusers,$user);
            }

        }
        if ($users === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $myusers;
    }



    /////////////////////////////
    /////  Get User By Id   /////
    /////////////////////////////

    /**
     * @Rest\Get("/user/{id}")
     */
    public function idAction($id)
    {
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        if ($user === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        return $user;
    }

    /////////////////////////////
    /////    Update User    /////
    /////////////////////////////

    /**
     * @Rest\Put("/user/{id}")
     * @param $id
     * @param Request $request
     * @return View
     */
    public function updateAction($id,Request $request)
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        $userManager = $this->get('fos_user.user_manager');


        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $phone = $request->get('phone');
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $plainpassword = $request->get('plainpassword');
        $roles = $request->get('roles');
        $active = $request->get('enabled');
        //$idcompany = $request->get('company');

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        //$company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($id);
        
        if($active=="true"){
                $user->setEnabled(true);
            }
            else{
                $user->setEnabled(false);
            }

            $user->setFirstName($first_name);
            $user->setLastName($last_name);

            $user->setPhone($phone);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setPlainPassword($plainpassword);
           // $user->setCompany($company);
            //$user->setRoles(array($roles));
            $em->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);



    }
    /**
     * @Rest\Put("/affect/{id}" , name="zeze")
     * @param $id
     * @param Request $request
     * @return View
     */
    public function affectAction($id,Request $request)
    {
        //var_dump('eeee');die();
        $em = $this->get('doctrine_mongodb')->getManager();
        $userManager = $this->get('fos_user.user_manager');

        $idcompany = $request->get('company');
        $idd = $request->get('id');
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($idcompany);
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($idd);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        //$company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($id);


         $user->setCompany($company);
        //$user->setRoles(array($roles));
        $em->flush();
        return new View("User Updated Successfully", Response::HTTP_OK);



    }




}
