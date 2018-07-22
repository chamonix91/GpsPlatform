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
    private $typeCarburant;

    /**
     * @MongoDB\Field(type="int")
     */
    private $puissance;

    /**
     * @MongoDB\Field(type="int")
     */
    private $rpmMax;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Box")
     */
    public $box;


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
}
