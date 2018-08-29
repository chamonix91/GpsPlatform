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
use Doctrine\ODM\MongoDB\Mapping\Annotations\Timestamp;


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
     * @MongoDB\Field(type="timestamp")
     */
    private $technical_visit;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $insurance;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $vignettes;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Box")
     */
    public $box;


    /**
     * @MongoDB\ReferenceOne(targetDocument="Driver", mappedBy="vehicle")
     */
    public $driver;

    /** @MongoDB\ReferenceOne(targetDocument="fleet", inversedBy="vehicles") */
    private $flot;


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
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
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
     * Set technicalVisit
     *
     * @param timestamp $technicalVisit
     * @return $this
     */
    public function setTechnicalVisit( $technicalVisit)
    {
        $this->technical_visit = $technicalVisit;
        return $this;
    }

    /**
     * Get technicalVisit
     *
     * @return timestamp $technicalVisit
     */
    public function getTechnicalVisit()
    {
        return $this->technical_visit;
    }

    /**
     * Set insurance
     *
     * @param timestamp $insurance
     * @return $this
     */
    public function setInsurance( $insurance)
    {
        $this->insurance = $insurance;
        return $this;
    }

    /**
     * Get insurance
     *
     * @return timestamp $insurance
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * Set vignettes
     *
     * @param timestamp $vignettes
     * @return $this
     */
    public function setVignettes( $vignettes)
    {
        $this->vignettes = $vignettes;
        return $this;
    }

    /**
     * Get vignettes
     *
     * @return timestamp $vignettes
     */
    public function getVignettes()
    {
        return $this->vignettes;
    }

    /**
     * Set box
     *
     * @param Box $box
     * @return $this
     */
    public function setBox( $box)
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
     * Set driver
     *
     * @param Driver $driver
     * @return $this
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * Get driver
     *
     * @return Driver $driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set flot
     *
     * @param fleet $flot
     * @return $this
     */
    public function setFlot(fleet $flot)
    {
        $this->flot = $flot;
        return $this;
    }

    /**
     * Get flot
     *
     * @return ApiGps fleet $flot
     */
    public function getFlot()
    {
        return $this->flot;
    }
}
