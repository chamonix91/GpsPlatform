<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 17/10/2018
 * Time: 23:13
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document
 */
class Installation
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $affectation_date;
    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $creation_date;
    /**
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Vehicle",inversedBy="installation")
     */
    private $vehicle;
    /**
     * @MongoDB\ReferenceOne(targetDocument="Vehicle",inversedBy="installation2")
     */
    private $vehicle2;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Box",mappedBy="installation")
     */
    public $box;

    /**
     * @MongoDB\ReferenceOne(targetDocument="ApiGps\EspaceUserBundle\Document\User",inversedBy="installation")
     */
    private $installateur;









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
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }


    /**
     * Set vehicle
     *
     * @param ApiGps\AdministrationBundle\Document\Vehicle $vehicle
     * @return $this
     */
    public function setVehicle(\ApiGps\AdministrationBundle\Document\Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    /**
     * Get vehicle
     *
     * @return ApiGps\AdministrationBundle\Document\Vehicle $vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set box
     *
     * @param ApiGps\AdministrationBundle\Document\Box $box
     * @return $this
     */
    public function setBox(\ApiGps\AdministrationBundle\Document\Box $box)
    {
        $this->box = $box;
        return $this;
    }

    /**
     * Get box
     *
     * @return ApiGps\AdministrationBundle\Document\Box $box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * Set installation
     *
     * @param ApiGps\EspaceUserBundle\Document\User $installation
     * @return $this
     */
    public function setInstallation(\ApiGps\EspaceUserBundle\Document\User $installation)
    {
        $this->installation = $installation;
        return $this;
    }

    /**
     * Get installation
     *
     * @return ApiGps\EspaceUserBundle\Document\User $installation
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Set affectationDate
     *
     * @param timestamp $affectationDate
     * @return $this
     */
    public function setAffectationDate($affectationDate)
    {
        $this->affectation_date = $affectationDate;
        return $this;
    }

    /**
     * Get affectationDate
     *
     * @return timestamp $affectationDate
     */
    public function getAffectationDate()
    {
        return $this->affectation_date;
    }

    /**
     * @return mixed
     */
    public function getVehicle2()
    {
        return $this->vehicle2;
    }

    /**
     * @param mixed $vehicle2
     */
    public function setVehicle2($vehicle2)
    {
        $this->vehicle2 = $vehicle2;
    }

    /**
     * Set installateur
     *
     * @param ApiGps\EspaceUserBundle\Document\User $installateur
     * @return $this
     */
    public function setInstallateur(\ApiGps\EspaceUserBundle\Document\User $installateur)
    {
        $this->installateur = $installateur;
        return $this;
    }

    /**
     * Get installateur
     *
     * @return ApiGps\EspaceUserBundle\Document\User $installateur
     */
    public function getInstallateur()
    {
        return $this->installateur;
    }
}
