<?php

namespace ApiGps\AdministrationBundle\Controller;


use ApiGps\AdministrationBundle\Document\Reclam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
class ReclamController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Rest\Get("/reclam/{id}")
     * @param $id
     * @return Reclam[]|array|View
     */
    public function getReclamAction($id)
    {
       //            ->findby(array('client'=> $user));

        $user=$this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);

        if ($user->getRoles() == "ROLE_ADMIN"){
            $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Reclam')->findAll();
        }else{
           $result = $user->getReclams();
        }

        //$result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Reclam')->findAll();
        if ($result === null) {
            return new View("there are no reclams exist", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    /**
     * @Rest\Post("/reclam")
     * @param Request $request
     * @return string
     */
    public function PostReclamAction (Request $request){

        $data = new Reclam();
        $topic = $request->get('topic');
        $message = $request->get('message');
        $email = $request->get('email');
        $status = $request->get('status');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->findOneByEmail($email);
        //var_dump($user);die();

        if(empty($email)|| empty($message))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setMessage($message);
        $data->setUser($user);
        $data->setTopic($topic);
        $data->setEtat($status);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Reclam added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/reclam/{id}")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updateReclamAction($id,Request $request)
    {
        $etat = $request->get('status');
        $reclam = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Reclam')->find($id);

        if (empty($reclam)) {
            return new View("Reclam not found", Response::HTTP_NOT_ACCEPTABLE);
        }

        $reclam->setEtat($etat);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $sn->flush();

        return new View("Reclam Updated Successfully", Response::HTTP_OK);

    }


}
