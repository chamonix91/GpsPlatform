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
     * @Rest\Get("/reclam")
     */
    public function getReclamAction()
    {

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Reclam')->findAll();
        if ($result === null) {
            return new View("there are no boxes exist", Response::HTTP_NOT_FOUND);
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
        $topic = $request->get('message');
        $message = $request->get('topic');
        $email = $request->get('email');
        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->findOneByEmail($email);
        //var_dump($user);die();

        if(empty($email)|| empty($message))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setMessage($message);
        $data->setUser($user);
        $data->setTopic($topic);
        $data->setEtat(false);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Reclam added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/reclam")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function updateReclamAction($id,Request $request)
    {
        $etat = $request->get('etat');
        $reclam = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Reclam')->find($id);

        if (empty($reclam)) {
            return new View("Reclam not found", Response::HTTP_NOT_ACCEPTABLE);
        }

        $reclam->setEtat($etat);
        $sn = $this->get('doctrine_mongodb')->getManager();
        $sn->flush();

        return new View("Vehicle Updated Successfully", Response::HTTP_OK);

    }


}
