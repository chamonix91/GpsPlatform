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
 * @MongoDB\Document(collection="trames")
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
     * @MongoDB\Field(type="string")
     */
    private $street;


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
     * @MongoDB\Field(type="string")
     */
    private $ain1;
    /**
     * @MongoDB\Field(type="string")
     */
    private $ain2;
    /**
     * @MongoDB\Field(type="string")
     */
    private $din1;
    /**
     * @MongoDB\Field(type="string")
     */
    private $din2;
    /**
     * @MongoDB\Field(type="string")
     */
    private $din3;
    /**
     * @MongoDB\Field(type="string")
     */
    private $din4;

    /**
     * @MongoDB\Field(type="string")
     */
    private $dallas0;
    /**
     * @MongoDB\Field(type="string")
     */
    private $dallas1;
    /**
     * @MongoDB\Field(type="string")
     */
    private $dallas2;
    /**
     * @MongoDB\Field(type="string")
     */
    private $dallas3;


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
    public function getAin1()
    {
        return $this->ain1;
    }

    /**
     * @param mixed $ain1
     */
    public function setAin1($ain1)
    {
        $this->ain1 = $ain1;
    }

    /**
     * @return mixed
     */
    public function getAin2()
    {
        return $this->ain2;
    }

    /**
     * @param mixed $ain2
     */
    public function setAin2($ain2)
    {
        $this->ain2 = $ain2;
    }

    /**
     * @return mixed
     */
    public function getDin1()
    {
        return $this->din1;
    }

    /**
     * @param mixed $din1
     */
    public function setDin1($din1)
    {
        $this->din1 = $din1;
    }

    /**
     * @return mixed
     */
    public function getDin2()
    {
        return $this->din2;
    }

    /**
     * @param mixed $din2
     */
    public function setDin2($din2)
    {
        $this->din2 = $din2;
    }

    /**
     * @return mixed
     */
    public function getDin3()
    {
        return $this->din3;
    }

    /**
     * @param mixed $din3
     */
    public function setDin3($din3)
    {
        $this->din3 = $din3;
    }

    /**
     * @return mixed
     */
    public function getDin4()
    {
        return $this->din4;
    }

    /**
     * @param mixed $din4
     */
    public function setDin4($din4)
    {
        $this->din4 = $din4;
    }

    /**
     * @return mixed
     */
    public function getDallas0()
    {
        return $this->dallas0;
    }

    /**
     * @param mixed $dallas0
     */
    public function setDallas0($dallas0)
    {
        $this->dallas0 = $dallas0;
    }

    /**
     * @return mixed
     */
    public function getDallas1()
    {
        return $this->dallas1;
    }

    /**
     * @param mixed $dallas1
     */
    public function setDallas1($dallas1)
    {
        $this->dallas1 = $dallas1;
    }

    /**
     * @return mixed
     */
    public function getDallas2()
    {
        return $this->dallas2;
    }

    /**
     * @param mixed $dallas2
     */
    public function setDallas2($dallas2)
    {
        $this->dallas2 = $dallas2;
    }

    /**
     * @return mixed
     */
    public function getDallas3()
    {
        return $this->dallas3;
    }

    /**
     * @param mixed $dallas3
     */
    public function setDallas3($dallas3)
    {
        $this->dallas3 = $dallas3;
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
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
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
