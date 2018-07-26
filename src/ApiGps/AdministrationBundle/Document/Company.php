<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 14/07/2018
 * Time: 08:56
 */

namespace ApiGps\AdministrationBundle\Document;

use ApiGps\EspaceUserBundle\Document\User;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @MongoDB\Document
 */
class Company
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
     * @MongoDB\Field(type="string")
     */
    private $adress;

    /**
     * @MongoDB\Field(type="string")
     */
    private $phone;

    /**
     * @MongoDB\Field(type="DateTime")
     */
    private $created_date;

    /**
     * @MongoDB\Field(type="DateTime")
     */
    private $end_date;

    /**
     * @MongoDB\Field(type="string")
     */
    private $cp_name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $cp_phone;

    /**
     * @MongoDB\Field(type="string")
     */
    private $cpa_name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $cpa_phone;

    /** @MongoDB\ReferenceMany(targetDocument="ApiGps\EspaceUserBundle\Document\User", mappedBy="company") */
    private $users;

    /** @MongoDB\ReferenceMany(targetDocument="ApiGps\AdministrationBundle\Document\Vehicle", mappedBy="company") */
    private $vehicles;


    public function __construct()
    {
        $this->created_date = new \DateTime('now');

        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vehicles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add user
     *
     * @param User $user
     */
    public function addUser(\ApiGps\EspaceUserBundle\Document\User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(\ApiGps\EspaceUserBundle\Document\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection $users
     */
    public function getUsers()
    {
        return $this->users;
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

    /**
     * Set adress
     *
     * @param string $adress
     * @return $this
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
        return $this;
    }

    /**
     * Get adress
     *
     * @return string $adress
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone
     *
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set createdDate
     *
     * @param DateTime $createdDate
     * @return $this
     */
    public function setCreatedDate(\DateTime $createdDate)
    {
        $this->created_date = $createdDate;
        return $this;
    }

    /**
     * Get createdDate
     *
     * @return DateTime $createdDate
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * Set endDate
     *
     * @param DateTime $endDate
     * @return $this
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->end_date = $endDate;
        return $this;
    }

    /**
     * Get endDate
     *
     * @return DateTime $endDate
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set cpName
     *
     * @param string $cpName
     * @return $this
     */
    public function setCpName($cpName)
    {
        $this->cp_name = $cpName;
        return $this;
    }

    /**
     * Get cpName
     *
     * @return string $cpName
     */
    public function getCpName()
    {
        return $this->cp_name;
    }

    /**
     * Set cpPhone
     *
     * @param string $cpPhone
     * @return $this
     */
    public function setCpPhone($cpPhone)
    {
        $this->cp_phone = $cpPhone;
        return $this;
    }

    /**
     * Get cpPhone
     *
     * @return string $cpPhone
     */
    public function getCpPhone()
    {
        return $this->cp_phone;
    }

    /**
     * Set cpaName
     *
     * @param string $cpaName
     * @return $this
     */
    public function setCpaName($cpaName)
    {
        $this->cpa_name = $cpaName;
        return $this;
    }

    /**
     * Get cpaName
     *
     * @return string $cpaName
     */
    public function getCpaName()
    {
        return $this->cpa_name;
    }

    /**
     * Set cpaPhone
     *
     * @param string $cpaPhone
     * @return $this
     */
    public function setCpaPhone($cpaPhone)
    {
        $this->cpa_phone = $cpaPhone;
        return $this;
    }

    /**
     * Get cpaPhone
     *
     * @return string $cpaPhone
     */
    public function getCpaPhone()
    {
        return $this->cpa_phone;
    }
}
