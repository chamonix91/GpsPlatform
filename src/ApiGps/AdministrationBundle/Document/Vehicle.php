<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/07/2018
 * Time: 19:04
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;


/**
 * @MongoDB\Document
 */
class Vehicle
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $reg_number;
    /**
     * @MongoDB\Field(type="float")
     */
    private $reservoir;

    /**
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @MongoDB\Field(type="string")
     */
    private $mark;

    /**
     * @MongoDB\Field(type="string")
     */
    private $model;

    /**
     * @MongoDB\Field(type="string")
     */
    private $fuel_type;

    /**
     * @MongoDB\Field(type="int")
     */
    private $puissance;

    /**
     * @MongoDB\Field(type="int")
     */
    private $rpmMax;

    /**
     * @MongoDB\Field(type="DateTime")
     */
    private $technical_visit;

    /**
     * @MongoDB\Field(type="DateTime")
     */
    private $insurance;

    /**
     * @MongoDB\Field(type="DateTime")
     */
    private $vignettes;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Box")
     */
    public $box;

    /** @MongoDB\ReferenceOne(targetDocument="ApiGps\AdministrationBundle\Document\Company", inversedBy="vehicles") */
    private $company;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set regNumber
     *
     * @param string $regNumber
     * @return $this
     */
    public function setRegNumber($regNumber)
    {
        $this->reg_number = $regNumber;
        return $this;
    }

    /**
     * Get regNumber
     *
     * @return string $regNumber
     */
    public function getRegNumber()
    {
        return $this->reg_number;
    }

    /**
     * Set box
     *
     * @param Box $box
     * @return $this
     */
    public function setBox(Box $box)
    {
        $this->box = $box;
        return $this;
    }

    /**
     * Get box
     *
     * @return Box $box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param mixed $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    /**
     * @return mixed
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * @param mixed $modele
     */
    public function setModele($modele)
    {
        $this->modele = $modele;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set reservoir
     *
     * @param float $reservoir
     * @return $this
     */
    public function setReservoir($reservoir)
    {
        $this->reservoir = $reservoir;
        return $this;
    }

    /**
     * Get reservoir
     *
     * @return float $reservoir
     */
    public function getReservoir()
    {
        return $this->reservoir;
    }

    /**
     * Set typeCarburant
     *
     * @param string $typeCarburant
     * @return $this
     */
    public function setTypeCarburant($typeCarburant)
    {
        $this->typeCarburant = $typeCarburant;
        return $this;
    }

    /**
     * Get typeCarburant
     *
     * @return string $typeCarburant
     */
    public function getTypeCarburant()
    {
        return $this->typeCarburant;
    }

    /**
     * Set puissance
     *
     * @param int $puissance
     * @return $this
     */
    public function setPuissance($puissance)
    {
        $this->puissance = $puissance;
        return $this;
    }

    /**
     * Get puissance
     *
     * @return int $puissance
     */
    public function getPuissance()
    {
        return $this->puissance;
    }

    /**
     * Set rpmMax
     *
     * @param int $rpmMax
     * @return $this
     */
    public function setRpmMax($rpmMax)
    {
        $this->rpmMax = $rpmMax;
        return $this;
    }

    /**
     * Get rpmMax
     *
     * @return int $rpmMax
     */
    public function getRpmMax()
    {
        return $this->rpmMax;
    }

    /**
     * Set mark
     *
     * @param string $mark
     * @return $this
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
        return $this;
    }

    /**
     * Get mark
     *
     * @return string $mark
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get model
     *
     * @return string $model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set fuelType
     *
     * @param string $fuelType
     * @return $this
     */
    public function setFuelType($fuelType)
    {
        $this->fuel_type = $fuelType;
        return $this;
    }

    /**
     * Get fuelType
     *
     * @return string $fuelType
     */
    public function getFuelType()
    {
        return $this->fuel_type;
    }

    /**
     * Set technicalVisit
     *
     * @param DateTime $technicalVisit
     * @return $this
     */
    public function setTechnicalVisit(\DateTime $technicalVisit)
    {
        $this->technical_visit = $technicalVisit;
        return $this;
    }

    /**
     * Get technicalVisit
     *
     * @return DateTime $technicalVisit
     */
    public function getTechnicalVisit()
    {
        return $this->technical_visit;
    }

    /**
     * Set insurance
     *
     * @param DateTime $insurance
     * @return $this
     */
    public function setInsurance(\DateTime $insurance)
    {
        $this->insurance = $insurance;
        return $this;
    }

    /**
     * Get insurance
     *
     * @return DateTime $insurance
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * Set vignettes
     *
     * @param DateTime $vignettes
     * @return $this
     */
    public function setVignettes(\DateTime $vignettes)
    {
        $this->vignettes = $vignettes;
        return $this;
    }

    /**
     * Get vignettes
     *
     * @return DateTime $vignettes
     */
    public function getVignettes()
    {
        return $this->vignettes;
    }

    /**
     * Set company
     *
     * @param ApiGps\AdministrationBundle\Document\Company $company
     * @return $this
     */
    public function setCompany(\ApiGps\AdministrationBundle\Document\Company $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get company
     *
     * @return ApiGps\AdministrationBundle\Document\Company $company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
