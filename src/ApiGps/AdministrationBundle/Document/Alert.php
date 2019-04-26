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
    private $libelle;

    /**
     * @MongoDB\Field(type="string")
     */
    private $type;
    /**
     * @MongoDB\Field(type="string")
     */
    private $radus;
    /**
     * @MongoDB\Field(type="float")
     */
    private $valeur;
    /**
     * @MongoDB\Field(type="float")
     */
    private $valeur1;
    /**
     * @MongoDB\Field(type="string")
     */
    private $description;


    /**
     * @MongoDB\Field(type="boolean")
     */
    private $active;


    /**
     * @MongoDB\ReferenceMany(targetDocument="Vehicle", inversedBy="alters")
     */
    private $vehicle;

    /** @MongoDB\ReferenceOne(targetDocument="Company", inversedBy="alerts") */
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
     * @return mixed
     */
    public function getValeur1()
    {
        return $this->valeur1;
    }

    /**
     * @param mixed $valeur1
     */
    public function setValeur1($valeur1)
    {
        $this->valeur1 = $valeur1;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return $this
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string $libelle
     */
    public function getLibelle()
    {
        return $this->libelle;
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
     * @return mixed
     */
    public function getRadus()
    {
        return $this->radus;
    }

    /**
     * @param mixed $radus
     */
    public function setRadus($radus)
    {
        $this->radus = $radus;
    }


    /**
     * Set valeur
     *
     * @param float $valeur
     * @return $this
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
        return $this;
    }

    /**
     * Get valeur
     *
     * @return float $valeur
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set vehicle
     *
     * @param Vehicle $vehicle
     * @return $this
     */
    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle[] = $vehicle;
        return $this;
    }
    public function remove(){
        $this->vehicle->remove();
    }

    /**
     * Get vehicle
     *
     * @return Vehicle $vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set company
     *
     * @param Company $company
     * @return $this
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get company
     *
     * @return Company $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
