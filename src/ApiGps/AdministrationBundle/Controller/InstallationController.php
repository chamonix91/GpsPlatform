<?php

namespace ApiGps\AdministrationBundle\Controller;


use ApiGps\AdministrationBundle\Document\Installation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Constraints\DateTime;


class InstallationController extends FOSRestController
{

    /**
     * @Rest\Post("/api/up")
     * @param Request $request
     * @Rest\View()
     * @return string
     */
    public function upAction(Request $request){
        $file = $request->files->get('File');
        //$a = new FileUploader($this->getParameter('brochures_directory'));
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('brochures_directory'), $fileName);
        return $fileName;
    }

    /////////////////////////////
    ///// Get installations /////
    /////////////////////////////

    /**
     * @Rest\Get("/installation")
     */
    public function getInstallationAction()
    {
        $restresult = $this->getDoctrine()->getRepository('ApiGpsAdministrationBundle:Installation')->findAll();
        if ($restresult === null) {
            return new View("there are no installations exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /////////////////////////////
    ///// Add installation  /////
    /////////////////////////////
    /**
     * @Rest\Post("/installation")
     * @param Request $request
     * @return string
     */
    public function postInstallationAction(Request $request)
    {
        $data = new Installation();

        $idbox = $request->get('idbox');
        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');
        $note = $request->get('note');


        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idbox);
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $installateur = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($idinstallateur);



        if( empty($idbox) || empty($idvehicle) || empty($idinstallateur))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setBox($box);
        $data->setType("Instalation");
        $data->setVehicle($vehicle);
        $data->setInstallateur($installateur);
        $a=new \DateTime('now');
        $b=$a->format('Y-m-d ');
        $bond_date = strtotime($b);
        $data->setCreationDate($bond_date);
        $data->setNote($note);
        $data->setStatus('ouvert');
        $box->setVehicle($vehicle);
        $vehicle->setBox($box);
        $this->updatebox($box);
        $this->updatevehicuel($vehicle);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();


        return new View("installation Added Successfully", Response::HTTP_OK);
    }

    ///////////////////////////////////////
    ///// intervention installation  //////
    ///////////////////////////////////////


    /**
     * @Rest\Post("/intervention")
     * @param Request $request
     * @return string
     */
    public function postInterventionAction(Request $request)
    {
        $data = new Installation();

        $idbox = $request->get('idbox');
        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');


        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idbox);
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $installateur = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($idinstallateur);


        if( empty($idbox) || empty($idvehicle) || empty($idinstallateur))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setBox($box);
        $data->setType("Intervention");
        $data->setVehicle($vehicle);
        $data->setInstallateur($installateur);
        $a=new \DateTime('now');
        $b=$a->format('Y-m-d ');
        $bond_date = strtotime($b);
        $data->setCreationDate($bond_date);
        $box->setVehicle($vehicle);
        $vehicle->setBox($box);
        $this->updatebox($box);
        $this->updatevehicuel($vehicle);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();


        return new View("installation Added Successfully", Response::HTTP_OK);
    }
    /**
     * @Rest\Post("/desinstallation")
     * @param Request $request
     * @return string
     */
    public function postDesnstallationAction(Request $request)
    {
        $data = new Installation();

        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');

        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->find($vehicle->getBox()->getId());

        $installateur = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($idinstallateur);


        if(  empty($idvehicle) || empty($idinstallateur))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setBox($box);
        $data->setVehicle($vehicle);
        $data->setInstallateur($installateur);
        $a=new \DateTime('now');
        $b=$a->format('Y-m-d ');
        $bond_date = strtotime($b);
        $data->setCreationDate($bond_date);
        $data->setType("Désinstalation");
        $box->setVehicle(null);
        $vehicle->setBox(null);
        $this->desbox($box);
        $this->desbox($vehicle);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();


        return new View("installation Added Successfully", Response::HTTP_OK);
    }
    /**
     * @Rest\Post("/transfere")
     * @param Request $request
     * @return string
     */
    public function postTransfereAction(Request $request)
    {
        $data = new Installation();

        $idvehicle = $request->get('idvehicle');
        $idvehicle2 = $request->get('idvehicle2');
        $idinstallateur = $request->get('idinstallateur');

        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $vehicle2 = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle2);
        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')
            ->find($vehicle->getBox()->getId());

        $installateur = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')
            ->find($idinstallateur);


        if(  empty($idvehicle) || empty($idinstallateur))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setBox($box);
        $data->setVehicle($vehicle2);
        $data->setVehicle2($vehicle);
        $data->setInstallateur($installateur);
        $a=new \DateTime('now');
        $b=$a->format('Y-m-d ');
        $bond_date = strtotime($b);
        $data->setCreationDate($bond_date);
        $data->setType("Tranfere");
        $box->setVehicle($vehicle2);
        $vehicle->setBox(null);
        $vehicle2->setBox($box);
        $this->desbox($box);
        $this->desbox($vehicle);
        $this->updatebox($box);
        $this->updatevehicuel($vehicle2);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();


        return new View("installation Added Successfully", Response::HTTP_OK);
    }
    public function desbox($a){
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->merge($a);
        $em->flush();
    }
    public function desvehicuel($a){
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->merge($a);
        $em->flush();
    }
    public function updatebox($a){
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->merge($a);
        $em->flush();
    }
    public function updatevehicuel($a){
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->merge($a);
        $em->flush();
    }

    /////////////////////////////
    ///// Modify installation  /////
    /////////////////////////////

    /**
     * @Rest\Put("/installation/{id}")
     * @param Request $request
     * @return string
     */
    public function modifyInstallationAction(Request $request)
    {
        $data = new Installation();

        $idbox = $request->get('idbox');
        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');


        $box = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Box')->find($idbox);
        $vehicle = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')->find($idvehicle);
        $installateur = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($idinstallateur);

        $data = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Installation')->find($id);



        if( empty($idbox) || empty($idvehicle) || empty($idinstallateur))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }

        if ($data->getVehicle() == $vehicle){

            $vehicle->setBox($box);

            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($vehicle);


        }

        if ($data->getBox() == $box){

            $box->setVehicle($vehicle);

            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($vehicle);


        }

        $data->setBox($box);
        $data->setVehicle($vehicle);
        $data->setInstallateur($installateur);

        $vehicle->setBox($box);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->persist($vehicle);
        $em->flush();

        return new View("installation updated Successfully", Response::HTTP_OK);
    }

    /////////////////////////////
    ///// Modify installation  /////
    /////////////////////////////

    /**
     * @Rest\Put("/finalizeIns/{id}")
     * @param Request $request
     * @return string
     */
    public function finalizeInstallationAction($id, Request $request)
    {
        $data = new Installation();



        $data = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Installation')->find($id);

        $image1 = $request->get('image1');
        $image2 = $request->get('image2');
        $image3 = $request->get('image3');
        $image4 = $request->get('image4');



        if( empty($data))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }



        $data->setImage1($image1);
        $data->setImage2($image2);
        $data->setImage3($image3);
        $data->setImage4($image4);
        $data->setStatus('ferme');

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("installation finalized Successfully", Response::HTTP_OK);
    }

}
