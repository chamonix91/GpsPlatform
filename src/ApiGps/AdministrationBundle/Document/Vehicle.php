<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/07/2018
 * Time: 19:04
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


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
     * @MongoDB\ReferenceOne(targetDocument="Box", mappedBy="vehicle")
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
}
