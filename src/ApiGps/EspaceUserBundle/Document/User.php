<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 14/07/2018
 * Time: 08:55
 */

namespace ApiGps\EspaceUserBundle\Document;

use ApiGps\AdministrationBundle\Document\Company;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\UserBundle\Model\User as BaseUser;



/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $first_name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $last_name;

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

    /** @MongoDB\ReferenceOne(targetDocument="ApiGps\AdministrationBundle\Document\Company", inversedBy="users") */
    private $company;


    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_CLIENT');
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
     * Set firstName
     *
     * @param string $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->last_name;
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
}
