<?php

namespace ApiGps\AdministrationBundle\Controller;

use ApiGps\AdministrationBundle\Document\Company;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class CompanyController extends FOSRestController
{

    /////////////////////////////
    ///// Get All companies /////
    /// /////////////////////////

    /**
     * @Rest\Get("/company")
     */
    public function getCompaniesAction()
    {
        $companies = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->findAll();
        if ($companies === null) {
            return new View("there are no companies exist", Response::HTTP_NOT_FOUND);
        }

        $formatted = [];
        foreach ($companies as $company) {
            $formatted[] = [
                'id' => $company->getId(),
                'name'=>$company->getName(),
                'adress'=>$company->getAdress(),
                'phone'=>$company->getPhone(),
                'created_date'=>$company->getCreatedDate(),
                'end_date'=>strtotime($company->getEndDate()),
                'cp_name'=>$company->getCpName(),
                'cp_phone'=>$company->getCpPhone(),
                'cpa_name'=>$company->getCpaName(),
                'cpa_phone'=>$company->getCpaPhone(),
            ];
        }

        return new JsonResponse($formatted);
    }


    /////////////////////////////
    ///// Get company By id /////
    /////////////////////////////

    /**
     * @Rest\Get("/company/{id}")
     * @param $id
     * @return Company|View|null|object
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
     * @Rest\Post("/up")
     * @param Request $request
     * @Rest\View()
     */
    public function upAction(Request $request){
        $file = $request->files->get('File');
        //$a = new FileUploader($this->getParameter('brochures_directory'));
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('brochures_directory'), $fileName);
        return $fileName;
    }
    /**
     * @Rest\Post("/company")
     * @param Request $request
     * @return View
     */
    public function addCompanyAction(Request $request)
    {
        //$date = new \DateTime('2008-09-22');


        $company = new Company();
        $adress = $request->get('adress');
        $cp_name = $request->get('cp_name');
        $cp_phone = $request->get('cp_phone');
        $cpa_name = $request->get('cpa_name');
        $cpa_phone = $request->get('cpa_phone');
        //$logo = $request->get('logo');
        if(empty($company))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $company->setAdress($adress);
        $company->setCpName($cp_name);
        $company->setCpPhone($cp_phone);
        $company->setCpaName($cpa_name);
        $company->setCpaPhone($cpa_phone);
        $company->setAdress($adress);
        //$company->setCpaPhone($logo);

        $em = $this->get('doctrine_mongodb')->getManager();
        $em->persist($company);
        $em->flush();
        return new View("Company Added Successfully", Response::HTTP_OK);
    }

    /////////////////////////////
    /////  update company   /////
    /////////////////////////////


    /**
     * @Rest\Put("/company/{id}")
     * @param $id
     * @param Request $request
     * @return View
     */
    public function updateCompanyAction($id,Request $request)
    {
        $name = $request->get('name');
        $adress = $request->get('adress');
        $phone = $request->get('phone');
        $created_date = $request->get('created_date');
        $end_date = $request->get('end_date');
        $cp_name = $request->get('cp_name');
        $cp_phone = $request->get('cp_phone');
        $cpa_name = $request->get('cpa_name');
        $cpa_phone = $request->get('cpa_phone');
        $logo = $request->get('logo');

        $em = $this->get('doctrine_mongodb')->getManager();
        $company = $this->get('doctrine_mongodb')->getRepository('ApiGpsAdministrationBundle:Company')->find($id);
        if (empty($company)) {
            return new View("company not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($company)){
            $company->setName($name);
            $company->setAdress($adress);
            $company->setPhone($phone);
            $company->setCreatedDate($created_date);
            $company->setEndDate($end_date);
            $company->setCpaName($cp_name);
            $company->setCpaPhone($cp_phone);
            $company->setCpaName($cpa_name);
            $company->setCpaPhone($cpa_phone);
            $company->setCpaPhone($logo);
            $em->flush();
            return new View("company Updated Successfully", Response::HTTP_OK);
        }

        else return new View("company name cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }



}
