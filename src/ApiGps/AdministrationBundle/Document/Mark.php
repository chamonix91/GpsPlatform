<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 31/08/2018
 * Time: 15:38
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * @MongoDB\Document
 */

class Mark
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $active;

    /** @MongoDB\ReferenceOne(targetDocument="Vehicle", inversedBy="marks") */
    private $vehicle;

    /** @MongoDB\ReferenceMany(targetDocument="Model", mappedBy="mark") */
    private $models;


    public function __construct()
    {
        $this->models = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set vehicle
     *
     * @param Vehicle $vehicle
     * @return $this
     */
    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        return $this;
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
     * Add model
     *
     * @param Model $model
     */
    public function addModel(Model $model)
    {
        $this->models[] = $model;
    }

    /**
     * Remove model
     *
     * @param Model $model
     */
    public function removeModel(Model $model)
    {
        $this->models->removeElement($model);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection $models
     */
    public function getModels()
    {
        return $this->models;
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
}
