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
     * @MongoDB\Field(type="float")
     */
    private $feelConsumed;

    /**
     * @MongoDB\Field(type="float")
     */
    private $feelLvl;

    /**
     * @MongoDB\Field(type="int")
     */
    private $engineRpm;

    /**
     * @MongoDB\Field(type="float")
     */
    private $feelLvlp;

    /**
     * @MongoDB\Field(type="int")
     */
    private $engineworktime;

    /**
     * @MongoDB\Field(type="int")
     */
    private $engineworktimecounted;

    /**
     * @MongoDB\Field(type="int")
     */
    private $engineload;

    /**
     * @MongoDB\Field(type="float")
     */
    private $enginetempirature;

    /**
     * @MongoDB\Field(type="float")
     */
    private $batrietempirature;

    /**
     * @MongoDB\Field(type="float")
     */
    private $batrieLvl;

    /**
     * @MongoDB\Field(type="float")
     */
    private $totalMileage;

    /**
     * @MongoDB\Field(type="float")
     */
    private $totalMileagec;

    /**
     * @MongoDB\Field(type="int")
     */
    private $contact;

    /**
     * @MongoDB\Field(type="float")
     */
    private $externalvoltage;
    /**
     * @MongoDB\ReferenceOne(targetDocument="Box", inversedBy="trame")
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


    /**
     * Set feelConsumed
     *
     * @param float $feelConsumed
     * @return $this
     */
    public function setFeelConsumed($feelConsumed)
    {
        $this->feelConsumed = $feelConsumed;
        return $this;
    }

    /**
     * Get feelConsumed
     *
     * @return float $feelConsumed
     */
    public function getFeelConsumed()
    {
        return $this->feelConsumed;
    }

    /**
     * Set feelLvl
     *
     * @param float $feelLvl
     * @return $this
     */
    public function setFeelLvl($feelLvl)
    {
        $this->feelLvl = $feelLvl;
        return $this;
    }

    /**
     * Get feelLvl
     *
     * @return float $feelLvl
     */
    public function getFeelLvl()
    {
        return $this->feelLvl;
    }

    /**
     * Set engineRpm
     *
     * @param int $engineRpm
     * @return $this
     */
    public function setEngineRpm($engineRpm)
    {
        $this->engineRpm = $engineRpm;
        return $this;
    }

    /**
     * Get engineRpm
     *
     * @return int $engineRpm
     */
    public function getEngineRpm()
    {
        return $this->engineRpm;
    }

    /**
     * Set feelLvlp
     *
     * @param float $feelLvlp
     * @return $this
     */
    public function setFeelLvlp($feelLvlp)
    {
        $this->feelLvlp = $feelLvlp;
        return $this;
    }

    /**
     * Get feelLvlp
     *
     * @return float $feelLvlp
     */
    public function getFeelLvlp()
    {
        return $this->feelLvlp;
    }

    /**
     * Set engineworktime
     *
     * @param int $engineworktime
     * @return $this
     */
    public function setEngineworktime($engineworktime)
    {
        $this->engineworktime = $engineworktime;
        return $this;
    }

    /**
     * Get engineworktime
     *
     * @return int $engineworktime
     */
    public function getEngineworktime()
    {
        return $this->engineworktime;
    }

    /**
     * Set engineworktimecounted
     *
     * @param int $engineworktimecounted
     * @return $this
     */
    public function setEngineworktimecounted($engineworktimecounted)
    {
        $this->engineworktimecounted = $engineworktimecounted;
        return $this;
    }

    /**
     * Get engineworktimecounted
     *
     * @return int $engineworktimecounted
     */
    public function getEngineworktimecounted()
    {
        return $this->engineworktimecounted;
    }

    /**
     * Set engineload
     *
     * @param int $engineload
     * @return $this
     */
    public function setEngineload($engineload)
    {
        $this->engineload = $engineload;
        return $this;
    }

    /**
     * Get engineload
     *
     * @return int $engineload
     */
    public function getEngineload()
    {
        return $this->engineload;
    }

    /**
     * Set enginetempirature
     *
     * @param float $enginetempirature
     * @return $this
     */
    public function setEnginetempirature($enginetempirature)
    {
        $this->enginetempirature = $enginetempirature;
        return $this;
    }

    /**
     * Get enginetempirature
     *
     * @return float $enginetempirature
     */
    public function getEnginetempirature()
    {
        return $this->enginetempirature;
    }

    /**
     * Set batrietempirature
     *
     * @param float $batrietempirature
     * @return $this
     */
    public function setBatrietempirature($batrietempirature)
    {
        $this->batrietempirature = $batrietempirature;
        return $this;
    }

    /**
     * Get batrietempirature
     *
     * @return float $batrietempirature
     */
    public function getBatrietempirature()
    {
        return $this->batrietempirature;
    }

    /**
     * Set batrieLvl
     *
     * @param float $batrieLvl
     * @return $this
     */
    public function setBatrieLvl($batrieLvl)
    {
        $this->batrieLvl = $batrieLvl;
        return $this;
    }

    /**
     * Get batrieLvl
     *
     * @return float $batrieLvl
     */
    public function getBatrieLvl()
    {
        return $this->batrieLvl;
    }

    /**
     * Set totalMileage
     *
     * @param float $totalMileage
     * @return $this
     */
    public function setTotalMileage($totalMileage)
    {
        $this->totalMileage = $totalMileage;
        return $this;
    }

    /**
     * Get totalMileage
     *
     * @return float $totalMileage
     */
    public function getTotalMileage()
    {
        return $this->totalMileage;
    }

    /**
     * Set totalMileagec
     *
     * @param float $totalMileagec
     * @return $this
     */
    public function setTotalMileagec($totalMileagec)
    {
        $this->totalMileagec = $totalMileagec;
        return $this;
    }

    /**
     * Get totalMileagec
     *
     * @return float $totalMileagec
     */
    public function getTotalMileagec()
    {
        return $this->totalMileagec;
    }

    /**
     * Set contact
     *
     * @param int $contact
     * @return $this
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * Get contact
     *
     * @return int $contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set externalvoltage
     *
     * @param float $externalvoltage
     * @return $this
     */
    public function setExternalvoltage($externalvoltage)
    {
        $this->externalvoltage = $externalvoltage;
        return $this;
    }

    /**
     * Get externalvoltage
     *
     * @return float $externalvoltage
     */
    public function getExternalvoltage()
    {
        return $this->externalvoltage;
    }
}
