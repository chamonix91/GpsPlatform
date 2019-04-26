<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Capteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class CapteurController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Put("/capteur/{id}")
     * @param Request $request
     * @return string
     */
    public function putCapteurAction(Request $request)
    {
        $id = $request->get('id');
        $idc = $request->get('idcapteur');
        $data = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->find($id);
        $capteur = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Capteur')
            ->find($idc);
        $capteur->addObjets($data);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($capteur);
        $em->flush();
        return new View($capteur->getObjets(), Response::HTTP_OK);
        //var_dump(new View($capteur, Response::HTTP_OK)) ;
    }
    /**
     * @Rest\Post("/capteur")
     * @param Request $request
     * @return string
     */
    public function postCapteurAction(Request $request)
    {
        $data = new Capteur();
        $type = $request->get('type');
        $ioement = $request->get('ioement');
        $key1 = $request->get('key1');
        $key2 = $request->get('key2');
        $valeur1 = $request->get('valeur1');
        $valeur2 = $request->get('valeur2');
        $nom = $request->get('nom');
        $description = $request->get('description');
        $data->setType($type);
        $data->setIoement($ioement);
        $data->setKey1($key1);
        $data->setKey2($key2);
        $data->setValeur1($valeur1);
        $data->setValeur1($valeur1);
        $data->setValeur2($valeur2);
        $data->setNom($nom);
        $data->setDescription($description);
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($data);
        $em->flush();
        return new View("fleet added Successfully", Response::HTTP_OK);
    }
    /**
     * @Rest\Get("/capteur/{id}")
     */
    public function getMycapteursAction(Request $request)
    {
        $id = $request->get('id');
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Vehicle')
            ->find($id);

        if ($results === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }


        foreach ($results->getCapteurs() as $fleet) {
            if(count($fleet->getObjets())>0) {
                $company[] = [
                    'id' => $fleet->getId(),
                    'nom' => $fleet->getNom(),
                    'key1' => $fleet->getKey1(),
                    'key2' => $fleet->getKey2(),
                    'description' => $fleet->getDescription(),
                    'ioement' => $fleet->getIoement(),
                    'valeur1' => $fleet->getValeur1(),
                    'valeur2' => $fleet->getValeur2(),
                    'type' => $fleet->getType(),
                    'object' => count($fleet->getObjets()),
                ];
            }else{
                $company[] = [
                    'id' => $fleet->getId(),
                    'nom' => $fleet->getNom(),
                    'key1' => $fleet->getKey1(),
                    'key2' => $fleet->getKey2(),
                    'description' => $fleet->getDescription(),
                    'ioement' => $fleet->getIoement(),
                    'valeur1' => $fleet->getValeur1(),
                    'valeur2' => $fleet->getValeur2(),
                    'type' => $fleet->getType(),
                ];

            }

        }
        if(count($results->getCapteurs())==0){
            return null;
        }
        else{
            return $company;
        }
    }
    /**
     * @Rest\Get("/capteur")
     */
    public function getAllcapteursAction(Request $request)
    {
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Capteur')
            ->findAll();

        if ($results === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }


        foreach ($results as $fleet) {
            if(count($fleet->getObjets())>0) {
                $company[] = [
                    'id' => $fleet->getId(),
                    'nom' => $fleet->getNom(),
                    'key1' => $fleet->getKey1(),
                    'key2' => $fleet->getKey2(),
                    'description' => $fleet->getDescription(),
                    'ioement' => $fleet->getIoement(),
                    'valeur1' => $fleet->getValeur1(),
                    'valeur2' => $fleet->getValeur2(),
                    'type' => $fleet->getType(),
                    //'object' => ($fleet->getObjets()),
                ];
            }else{
                $company[] = [
                    'id' => $fleet->getId(),
                    'nom' => $fleet->getNom(),
                    'key1' => $fleet->getKey1(),
                    'key2' => $fleet->getKey2(),
                    'description' => $fleet->getDescription(),
                    'ioement' => $fleet->getIoement(),
                    'valeur1' => $fleet->getValeur1(),
                    'valeur2' => $fleet->getValeur2(),
                    'type' => $fleet->getType(),
                ];

            }

        }
        if(count($results)==0){
            return null;
        }
        else{
            return $company;
        }
    }

    /**
     * @Rest\Put("/unsetcapteur/{id}/{id1}")
     * @param Request $request
     * @return string
     */
    public function getUnsetcapteursAction(Request $request)
    {
        $id = $request->get('id');
        $id1 = $request->get('id1');
        $results = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Capteur')
            ->find($id);

        if ($results === null) {
            return new View("there are no fleet exist", Response::HTTP_NOT_FOUND);
        }

        $x=0;
        foreach ($results->getObjets() as $fleet) {
            if($fleet->getId()==$id1){
                unset($results->getObjets()[$x]);
            }
            $x++;
        }
        $sn = $this->get('doctrine_mongodb')->getManager();
        $sn->merge($results);
        $sn->flush();
        return new View("Vehicle Updated Successfully", Response::HTTP_OK);

    }

    }
