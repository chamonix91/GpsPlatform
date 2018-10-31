<?php

namespace ApiGps\AdministrationBundle\Controller;


use ApiGps\AdministrationBundle\Document\Installation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


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
    public function getInstallationsAction()
    {
        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Installation')->findAll();
        if ($result === null) {
            return new View("there are no installations exist", Response::HTTP_NOT_FOUND);
        }
        foreach ($result as $install) {

            if ($install->getType() == "Transfere") {

                if ($install->getVehicle()->getType() == "depot") {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'positionx' => $install->getVehicle()->getPositionx(),
                        'positiony' => $install->getVehicle()->getPositiony(),
                        'position2x' => $install->getVehicle2()->getPositionx(),
                        'position2y' => $install->getVehicle2()->getPositiony(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                } elseif ($install->getVehicle()->getType() == "personne") {
                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),

                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'nom' => $install->getVehicle()->getNom(),
                        'prenom' => $install->getVehicle()->getPrenom(),

                        'nom2' => $install->getVehicle2()->getNom(),
                        'prenom2' => $install->getVehicle2()->getPrenom(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];

                } else {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'reg_number' => $install->getVehicle()->getRegNumber(),
                        'mark' => $install->getVehicle()->getMark(),
                        'model' => $install->getVehicle()->getModel(),
                        'reg_number2' => $install->getVehicle2()->getRegNumber(),
                        'mark2' => $install->getVehicle2()->getMark(),
                        'model2' => $install->getVehicle2()->getModel(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                }
            }

            else{

                if ($install->getVehicle()->getType() == "depot") {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'positionx' => $install->getVehicle()->getPositionx(),
                        'positiony' => $install->getVehicle()->getPositiony(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                } elseif ($install->getVehicle()->getType() == "personne") {
                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),

                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'nom' => $install->getVehicle()->getNom(),
                        'prenom' => $install->getVehicle()->getPrenom(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];

                } else {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'reg_number' => $install->getVehicle()->getRegNumber(),
                        'mark' => $install->getVehicle()->getMark(),
                        'model' => $install->getVehicle()->getModel(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                }
            }


        }

        return $formatted;    }

    /////////////////////////////////////////
    ////////// Get My Installations   ///////
    /////////////////////////////////////////

    /**
     * @Rest\Get("/Myinstallation/{id}")
     */
    public function getMyInstallationsAction(Request $request)
    {

        $id = $request->get('id');

        $user = $this->get('doctrine_mongodb')->getRepository('ApiGpsEspaceUserBundle:User')->find($id);

        $result = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Installation')->findBy(array('installateur'=>$user));
        if ($result === null) {
            return new View("there are no installations exist", Response::HTTP_NOT_FOUND);
        }


        foreach ($result as $install) {

            if ($install->getType() == "Transfere") {

                if ($install->getVehicle()->getType() == "depot") {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'positionx' => $install->getVehicle()->getPositionx(),
                        'positiony' => $install->getVehicle()->getPositiony(),
                        'position2x' => $install->getVehicle2()->getPositionx(),
                        'position2y' => $install->getVehicle2()->getPositiony(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                } elseif ($install->getVehicle()->getType() == "personne") {
                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),

                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'nom' => $install->getVehicle()->getNom(),
                        'prenom' => $install->getVehicle()->getPrenom(),

                        'nom2' => $install->getVehicle2()->getNom(),
                        'prenom2' => $install->getVehicle2()->getPrenom(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];

                } else {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'reg_number' => $install->getVehicle()->getRegNumber(),
                        'mark' => $install->getVehicle()->getMark(),
                        'model' => $install->getVehicle()->getModel(),
                        'reg_number2' => $install->getVehicle2()->getRegNumber(),
                        'mark2' => $install->getVehicle2()->getMark(),
                        'model2' => $install->getVehicle2()->getModel(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                }
            }

            else{

                if ($install->getVehicle()->getType() == "depot") {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'positionx' => $install->getVehicle()->getPositionx(),
                        'positiony' => $install->getVehicle()->getPositiony(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                } elseif ($install->getVehicle()->getType() == "personne") {
                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),

                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'nom' => $install->getVehicle()->getNom(),
                        'prenom' => $install->getVehicle()->getPrenom(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];

                } else {

                    $formatted[] = [
                        'id' => $install->getId(),
                        'affectation_date' => date('Y-m-d', $install->getAffectationDate()->sec),
                        'creation_date' => date('Y-m-d', $install->getCreationDate()->sec),
                        'type' => $install->getType(),
                        'note' => $install->getNote(),
                        'status' => $install->getStatus(),
                        'image1' => $install->getImage1(),
                        'image2' => $install->getImage2(),
                        'image3' => $install->getImage3(),
                        'image4' => $install->getImage4(),
                        'reg_number' => $install->getVehicle()->getRegNumber(),
                        'mark' => $install->getVehicle()->getMark(),
                        'model' => $install->getVehicle()->getModel(),
                        'imei' => $install->getBox()->getImei(),
                        'installateur' => $install->getInstallateur(),


                    ];
                }
            }


        }

        return $formatted;
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

        $data->setStatus(true);
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
        $note = $request->get('note');


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
        $data->setNote($note);
        $data->setStatus(true);
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

    ///////////////////////////////////////
    ///////// uninstallation  /////////////
    ///////////////////////////////////////


    /**
     * @Rest\Post("/desinstallation")
     * @param Request $request
     * @return string
     */
    public function postDesinstallationAction(Request $request)
    {
        $data = new Installation();

        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');
        $note = $request->get('note');

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
        $data->setNote($note);
        $data->setStatus(true);
        $this->desbox($box);
        $this->desbox($vehicle);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();


        return new View("installation Added Successfully", Response::HTTP_OK);
    }

    ///////////////////////////////////////
    /////////    transfert    /////////////
    ///////////////////////////////////////


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
        $note = $request->get('note');

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
        $data->setNote($note);
        $data->setStatus(true);
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

    ////////////////////////////////
    ///// Modify installation  /////
    ////////////////////////////////

    /**
     * @Rest\Put("/installation/{id}")
     * @param Request $request
     * @return string
     */
    public function modifyInstallationAction(Request $request)
    {
        //$data = new Installation();

        $id = $request->get('id');

        $idbox = $request->get('idbox');
        $idvehicle = $request->get('idvehicle');
        $idinstallateur = $request->get('idinstallateur');
        $note = $request->get('note');


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
            $data->setNote($note);
            $data->setStatus(true);
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

    //////////////////////////////////
    ///// finalize installation  /////
    //////////////////////////////////

    /**
     * @Rest\Put("/finalizeIns/{id}")
     * @param Request $request
     * @return string
     */
    public function finalizeInstallationAction(Request $request)
    {
        $data = new Installation();

        $id = $request->get('id');

        $data = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Installation')->find($id);

        $note = $request->get('note');
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
        $data->setStatus(false);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("installation finalized Successfully", Response::HTTP_OK);
    }

    ////////////////////////////////////////////
    ///// finalize installation SuperAdmin /////
    ////////////////////////////////////////////

    /**
     * @Rest\Put("/finalizeInsSa/{id}")
     * @param Request $request
     * @return string
     */
    public function finalizeInstallationSaAction($id, Request $request)
    {
        $data = new Installation();
        $id = $request->get('id');

        $data = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Installation')->find($id);

        $note = $request->get('note');




        if( empty($data))
        {
            return "NULL VALUES ARE NOT ALLOWED";
        }
        $data->setNote($note);
        $data->setStatus(false);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();

        return new View("installation finalized Successfully", Response::HTTP_OK);
    }

}
