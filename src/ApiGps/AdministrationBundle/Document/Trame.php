<?php
/**
 * Created by PhpStorm.
 * User: Cyrine Hammémi
 * Date: 17/07/2018
 * Time: 10:33
 */
namespace ApiGps\AdministrationBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Trame
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $header;
    /**
     * @MongoDB\Field(type="string")
     */
    private $codecid;
    /**
     * @MongoDB\Field(type="string")
     */
    private $priority;
    /**
     * @MongoDB\Field(type="string")
     */
    private $nbrdata;
    /**
     * @MongoDB\Field(type="string")
     */
    private $timestamp;
    /**
     * @MongoDB\Field(type="string")
     */
    private $longitude;
    /**
     * @MongoDB\Field(type="string")
     */
    private $latitude;
    /**
     * @MongoDB\Field(type="string")
     */
    private $altitude;
    /**
     * @MongoDB\Field(type="string")
     */
    private $angle;
    /**
     * @MongoDB\Field(type="string")
     */
    private $sat;
    /**
     * @MongoDB\Field(type="string")
     */
    private $speed;
    /**
     * @MongoDB\ReferenceMany(targetDocument="Box", mappedBy="trame")
     */
    private $box;

    public function __construct()
    {
        $this->speed = new ArrayCollection();
    }

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
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getCodecid()
    {
        return $this->codecid;
    }

    /**
     * @param mixed $codecid
     */
    public function setCodecid($codecid)
    {
        $this->codecid = $codecid;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getNbrdata()
    {
        return $this->nbrdata;
    }

    /**
     * @param mixed $nbrdata
     */
    public function setNbrdata($nbrdata)
    {
        $this->nbrdata = $nbrdata;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param mixed $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }

    /**
     * @return mixed
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * @param mixed $angle
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;
    }

    /**
     * @return mixed
     */
    public function getSat()
    {
        return $this->sat;
    }

    /**
     * @param mixed $sat
     */
    public function setSat($sat)
    {
        $this->sat = $sat;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param mixed $speed
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    /**
     * @return mixed
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * @param mixed $box
     */
    public function setBox($box)
    {
        $this->box = $box;
    }


}
