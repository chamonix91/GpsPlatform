<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 28/10/2018
 * Time: 13:48
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Timestamp;


/**
 * @MongoDB\Document
 */
class Alert
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $libele;

    /**
     * @MongoDB\Field(type="string")
     */
    private $type;
    /**
     * @MongoDB\Field(type="float")
     */
    private $valeur;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Vehicle", inversedBy="alters")
     */
    private $vehicle;

    /** @MongoDB\ReferenceOne(targetDocument="Company", inversedBy="alerts") */
    private $comapny;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getComapny()
    {
        return $this->comapny;
    }

    /**
     * @param mixed $comapny
     */
    public function setComapny($comapny)
    {
        $this->comapny = $comapny;
    }


    /**
     * @return mixed
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param mixed $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }


    /**
     * @return mixed
     */
    public function getLibele()
    {
        return $this->libele;
    }

    /**
     * @param mixed $libele
     */
    public function setLibele($libele)
    {
        $this->libele = $libele;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * @param mixed $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }



}