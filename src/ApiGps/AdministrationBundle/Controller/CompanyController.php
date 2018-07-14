<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Company;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class CompanyController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    /////////////////////////////
    ///// Get All companies /////
    /// /////////////////////////
    /**
     * @Rest\Get("/company")
     */
    public function getCompanyAction()
    {
        $companies = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->findAll();
        if ($companies === null) {
            return new View("there are no companies exist", Response::HTTP_NOT_FOUND);
        }
        return $companies;
    }


    /////////////////////////////
    ///// Get company By id /////
    /////////////////////////////

    /**
     * @Rest\Get("/company/{id}")
     */
    public function GetCompanyByIdAction($id)
    {
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($id);
        if ($company === null) {
            return new View("company not found", Response::HTTP_NOT_FOUND);
        }
        return $company;
    }

    /////////////////////////////
    /////  Create company   /////
    /////////////////////////////

    /**
     * @Rest\Post("/company")
     * @param Request $request
     * @return View
     */
    public function addCompanyAction(Request $request)
    {
        $company = new Company();
        $name = $request->get('name');
        if(empty($name))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $company->setName($name);
        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($company);
        $em->flush();
        return new View("Company Added Successfully", Response::HTTP_OK);
    }



}
