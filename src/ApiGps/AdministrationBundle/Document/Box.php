<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/07/2018
 * Time: 19:04
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document
 */
class Box
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $phone_num;


    /**
     * @MongoDB\Field(type="string")
     */
    private $imei;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Vehicle", inversedBy="box")
     */
    public $vehicle;


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
     * Set phoneNum
     *
     * @param string $phoneNum
     * @return $this
     */
    public function setPhoneNum($phoneNum)
    {
        $this->phone_num = $phoneNum;
        return $this;
    }

    /**
     * Get phoneNum
     *
     * @return string $phoneNum
     */
    public function getPhoneNum()
    {
        return $this->phone_num;
    }

    /**
     * Set imei
     *
     * @param string $imei
     * @return $this
     */
    public function setImei($imei)
    {
        $this->imei = $imei;
        return $this;
    }

    /**
     * Get imei
     *
     * @return string $imei
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set vehicle
     *
     * @param Vehicle $vehicle
     * @return $this
     */
    public function setVehicle(\ApiGps\AdministrationBundle\Document\Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    /**
     * Get vehicle
     *
     * @return ApiGps\AdministrationBundle\Document\Vehicle $vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }
}
