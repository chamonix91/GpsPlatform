<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 23/08/2018
 * Time: 22:12
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document
 */
class Driver
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $firstname;

    /**
     * @MongoDB\Field(type="string")
     */
    private $lastname;

    /**
     * @MongoDB\Field(type="string")
     */
    private $tel;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $bond_date;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $endbond_date;

    /**
     * @MongoDB\ReferenceOne(targetDocument="ApiGps\AdministrationBundle\Document\Vehicle", inversedBy="driver")
     */
    public $vehicle;

    /** @MongoDB\ReferenceOne(targetDocument="ApiGps\AdministrationBundle\Document\Company", inversedBy="drivers")
     */
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
     * Set firstname
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return $this
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
        return $this;
    }

    /**
     * Get tel
     *
     * @return string $tel
     */
    public function getTel()
    {
        return $this->tel;
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
     * Set bondDate
     *
     * @param string $bondDate
     * @return $this
     */
    public function setBondDate($bondDate)
    {
        $this->bond_date = $bondDate;
        return $this;
    }

    /**
     * Get bondDate
     *
     * @return string $bondDate
     */
    public function getBondDate()
    {
        return $this->bond_date;
    }

    /**
     * Set endbondDate
     *
     * @param string $endbondDate
     * @return $this
     */
    public function setEndbondDate($endbondDate)
    {
        $this->endbond_date = $endbondDate;
        return $this;
    }

    /**
     * Get endbondDate
     *
     * @return string $endbondDate
     */
    public function getEndbondDate()
    {
        return $this->endbond_date;
    }
}
