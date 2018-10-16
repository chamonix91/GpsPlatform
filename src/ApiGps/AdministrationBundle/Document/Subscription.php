<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 14/10/2018
 * Time: 19:07
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * @MongoDB\Document
 */

class Subscription
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $subType;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $start_date;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $end_date;

    /**
     * @MongoDB\ReferenceOne(targetDocument="ApiGps\AdministrationBundle\Document\Box", inversedBy="subscription")
     */
    public $box;

    /**
     * @MongoDB\ReferenceOne(targetDocument="ApiGps\AdministrationBundle\Document\Company", inversedBy="company")
     */
    public $company;







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
     * Set subType
     *
     * @param string $subType
     * @return $this
     */
    public function setSubType($subType)
    {
        $this->subType = $subType;
        return $this;
    }

    /**
     * Get subType
     *
     * @return string $subType
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * Set startDate
     *
     * @param timestamp $startDate
     * @return $this
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
        return $this;
    }

    /**
     * Get startDate
     *
     * @return timestamp $startDate
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set endDate
     *
     * @param timestamp $endDate
     * @return $this
     */
    public function setEndDate($endDate)
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
     * Set company
     *
     * @param ApiGps\AdministrationBundle\Document\Company $company
     * @return $this
     */
    public function setCompany(\ApiGps\AdministrationBundle\Document\Company $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get company
     *
     * @return ApiGps\AdministrationBundle\Document\Company $company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
