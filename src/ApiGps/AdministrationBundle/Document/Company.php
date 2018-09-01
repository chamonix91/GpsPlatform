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
    private $adress="";

    /**
     * @MongoDB\Field(type="string")
     */
    private $phone="";

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $created_date;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $end_date;

    /**
     * @MongoDB\Field(type="string")
     */
    private $cp_name="";

    /**
     * @MongoDB\Field(type="string")
     */
    private $cp_phone="";

    /**
     * @MongoDB\Field(type="string")
     */
    private $cpa_name="";

    /**
     * @MongoDB\Field(type="string")
     */
    private $cpa_phone="";

    /**
     * @MongoDB\Field(type="string")
     */
    private $logo;

    /** @MongoDB\ReferenceMany(targetDocument="ApiGps\EspaceUserBundle\Document\User", mappedBy="company") */
    private $users;

    /** @MongoDB\ReferenceMany(targetDocument="ApiGps\AdministrationBundle\Document\fleet", mappedBy="company") */
    private $fleets;

    /** @MongoDB\ReferenceMany(targetDocument="ApiGps\AdministrationBundle\Document\Driver", mappedBy="company") */
    private $drivers;

    /** @MongoDB\ReferenceMany(targetDocument="Box", mappedBy="company") */
    private $boxes;


    public function __construct()
    {
        $date = new \DateTime('now');
        $this->created_date =$date->getTimestamp();

        $this->users = new ArrayCollection();
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
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
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
     * Set endDate
     *
     * @param timestamp $endDate
     * @return $this
     */
    public function setEndDate( $endDate)
    {
        $this->end_date = $endDate;
        return $this;
    }

    /**
     * Get endDate
     *
     * @return timestamp $endDate
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

    /**
     * Set createdDate
     *
     * @param timestamp $createdDate
     * @return $this
     */
    public function setCreatedDate($createdDate)
    {
        $this->created_date = $createdDate;
        return $this;
    }

    /**
     * Get createdDate
     *
     * @return int $createdDate
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * Add fleet
     *
     * @param fleet $fleet
     */
    public function addFleet(fleet $fleet)
    {
        $this->fleets[] = $fleet;
    }

    /**
     * Remove fleet
     *
     * @param fleet $fleet
     */
    public function removeFleet(fleet $fleet)
    {
        $this->fleets->removeElement($fleet);
    }

    /**
     * Get fleets
     *
     * @return \Doctrine\Common\Collections\Collection $fleets
     */
    public function getFleets()
    {
        return $this->fleets;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * Get logo
     *
     * @return string $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Add driver
     *
     * @param Driver $driver
     */
    public function addDriver(Driver $driver)
    {
        $this->drivers[] = $driver;
    }

    /**
     * Remove driver
     *
     * @param Driver $driver
     */
    public function removeDriver(Driver $driver)
    {
        $this->drivers->removeElement($driver);
    }

    /**
     * Get drivers
     *
     * @return \Doctrine\Common\Collections\Collection $drivers
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * Add box
     *
     * @param Box $box
     */
    public function addBox(Box $box)
    {
        $this->boxes[] = $box;
    }

    /**
     * Remove box
     *
     * @param Box $box
     */
    public function removeBox(Box $box)
    {
        $this->boxes->removeElement($box);
    }

    /**
     * Get boxes
     *
     * @return \Doctrine\Common\Collections\Collection $boxes
     */
    public function getBoxes()
    {
        return $this->boxes;
    }
}
