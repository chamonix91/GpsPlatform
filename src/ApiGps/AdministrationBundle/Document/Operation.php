<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 31/01/2019
 * Time: 14:10
 */

namespace ApiGps\AdministrationBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
/**
 * @MongoDB\Document
 */
class Operation
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $libelle;

    /**
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @MongoDB\Field(type="float")
     */
    private $price;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $operation_date;


    /**
     * @MongoDB\Field(type="boolean")
     */
    private $active;


    /**
     * @MongoDB\ReferenceMany(targetDocument="Vehicle", inversedBy="operations")
     */
    private $vehicle;

    /** @MongoDB\ReferenceOne(targetDocument="Company", inversedBy="operations") */
    private $company;


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
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getOperationDate()
    {
        return $this->operation_date;
    }

    /**
     * @param mixed $operation_date
     */
    public function setOperationDate($operation_date)
    {
        $this->operation_date = $operation_date;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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
        $this->vehicle[] = $vehicle;
    }
    public function remove(){
        $this->vehicle->remove();
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }





}