<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 24/08/2018
 * Time: 11:19
 */

namespace ApiGps\AdministrationBundle\Document;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class fleet
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /** @MongoDB\ReferenceOne(targetDocument="Company", inversedBy="fleets") */
    private $comapny;

    /** @MongoDB\ReferenceMany(targetDocument="Vehicle") */
    private $vehicles;

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
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set comapny
     *
     * @param Company $comapny
     * @return $this
     */
    public function setComapny(Company $comapny)
    {
        $this->comapny = $comapny;
        return $this;
    }

    /**
     * Get comapny
     *
     * @return Company $comapny
     */
    public function getComapny()
    {
        return $this->comapny;
    }
    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }
    
    /**
     * Add vehicle
     *
     * @param Vehicle $vehicle
     */
    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles[] = $vehicle;
    }

    /**
     * Remove vehicle
     *
     * @param Vehicle $vehicle
     */
    public function removeVehicle(Vehicle $vehicle)
    {
        $this->vehicles->removeElement($vehicle);
    }

    /**
     * Get vehicles
     *
     * @return \Doctrine\Common\Collections\Collection $vehicles
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }
}
