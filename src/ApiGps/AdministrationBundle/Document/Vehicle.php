<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/07/2018
 * Time: 19:04
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Timestamp;


/**
 * @MongoDB\Document
 */
class Vehicle
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $reg_number;
    /**
     * @MongoDB\Field(type="string")
     */
    private $nom;
    /**
     * @MongoDB\Field(type="string")
     */
    private $prenom;
    /**
     * @MongoDB\Field(type="string")
     */
    private $libele;
    /**
     * @MongoDB\Field(type="string")
     */
    private $adress;
    /**
     * @MongoDB\Field(type="string")
     */
    private $positionx;
    /**
     * @MongoDB\Field(type="string")
     */
    private $positiony;
    /**
     * @MongoDB\Field(type="float")
     */
    private $reservoir;

    /**
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @MongoDB\Field(type="string")
     */
    private $mark;

    /**
     * @MongoDB\Field(type="string")
     */
    private $model;

    /**
     * @MongoDB\Field(type="string")
     */
    private $fuel_type;

    /**
     * @MongoDB\Field(type="int")
     */
    private $puissance;

    /**
     * @MongoDB\Field(type="int")
     */
    private $rpmMax;

    /**
     * @MongoDB\Field(type="int")
     */
    private $videngekm;

    /**
     * @MongoDB\Field(type="int")
     */
    private $videngetime;


    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $technical_visit;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $insurance;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $vignettes;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $active;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Alert",mappedBy="vehicle")
     */
    private $alters;

    /**
     * @return mixed
     */
    public function getAlters()
    {
        return $this->alters;
    }

    /**
     * @param mixed $alters
     */
    public function setAlters($alters)
    {
        $this->alters[] = $alters;
    }


    /**
     * @MongoDB\ReferenceOne(targetDocument="Box",mappedBy="vehicle")
     */
    public $box;


    /**
     * @MongoDB\ReferenceOne(targetDocument="Driver", mappedBy="vehicle")
     */
    public $driver;

    /**
     * @MongoDB\ReferenceOne(targetDocument="installation", mappedBy="vehicle")
     */
    public $installation;
    /**
     * @MongoDB\ReferenceOne(targetDocument="installation", mappedBy="vehicle2")
     */
    public $installation2;

    /** @MongoDB\ReferenceOne(targetDocument="fleet", inversedBy="vehicles") */
    private $flot;

    /** @MongoDB\ReferenceMany(targetDocument="Mark", mappedBy="vehicle") */
    private $marks;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Capteur", mappedBy="objets")
     */
    private $capteurs;


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
     * Set regNumber
     *
     * @param string $regNumber
     * @return $this
     */
    public function setRegNumber($regNumber)
    {
        $this->reg_number = $regNumber;
        return $this;
    }

    /**
     * Get regNumber
     *
     * @return string $regNumber
     */
    public function getRegNumber()
    {
        return $this->reg_number;
    }

    /**
     * @return mixed
     */
    public function getCapteurs()
    {
        return $this->capteurs;
    }

    /**
     * @param mixed $capteurs
     */
    public function setCapteurs($capteurs)
    {
        $this->capteurs[] = $capteurs;
    }



    /**
     * Set reservoir
     *
     * @param float $reservoir
     * @return $this
     */
    public function setReservoir($reservoir)
    {
        $this->reservoir = $reservoir;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstallation2()
    {
        return $this->installation2;
    }

    /**
     * @param mixed $installation2
     */
    public function setInstallation2($installation2)
    {
        $this->installation2 = $installation2;
    }

    /**
     * Get reservoir
     *
     * @return float $reservoir
     */
    public function getReservoir()
    {
        return $this->reservoir;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set mark
     *
     * @param string $mark
     * @return $this
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
        return $this;
    }

    /**
     * Get mark
     *
     * @return string $mark
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLibele()
    {
        return $this->libele;
    }

    /**
     * @param mixed $libele
     */
    public function setLibele($libele)
    {
        $this->libele = $libele;
    }

    /**
     * Get model
     *
     * @return string $model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getVidengekm()
    {
        return $this->videngekm;
    }

    /**
     * @param mixed $videngekm
     */
    public function setVidengekm($videngekm)
    {
        $this->videngekm = $videngekm;
    }

    /**
     * @return mixed
     */
    public function getVidengetime()
    {
        return $this->videngetime;
    }

    /**
     * @param mixed $videngetime
     */
    public function setVidengetime($videngetime)
    {
        $this->videngetime = $videngetime;
    }


    /**
     * Set fuelType
     *
     * @param string $fuelType
     * @return $this
     */
    public function setFuelType($fuelType)
    {
        $this->fuel_type = $fuelType;
        return $this;
    }

    /**
     * Get fuelType
     *
     * @return string $fuelType
     */
    public function getFuelType()
    {
        return $this->fuel_type;
    }

    /**
     * Set puissance
     *
     * @param int $puissance
     * @return $this
     */
    public function setPuissance($puissance)
    {
        $this->puissance = $puissance;
        return $this;
    }

    /**
     * Get puissance
     *
     * @return int $puissance
     */
    public function getPuissance()
    {
        return $this->puissance;
    }




    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }


    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getPositionx()
    {
        return $this->positionx;
    }

    /**
     * @param mixed $positionx
     */
    public function setPositionx($positionx)
    {
        $this->positionx = $positionx;
    }

    /**
     * @return mixed
     */
    public function getPositiony()
    {
        return $this->positiony;
    }

    /**
     * @param mixed $positiony
     */
    public function setPositiony($positiony)
    {
        $this->positiony = $positiony;
    }


    /**
     * Set rpmMax
     *
     * @param int $rpmMax
     * @return $this
     */
    public function setRpmMax($rpmMax)
    {
        $this->rpmMax = $rpmMax;
        return $this;
    }

    /**
     * Get rpmMax
     *
     * @return int $rpmMax
     */
    public function getRpmMax()
    {
        return $this->rpmMax;
    }

    /**
     * Set technicalVisit
     *
     * @param timestamp $technicalVisit
     * @return $this
     */
    public function setTechnicalVisit( $technicalVisit)
    {
        $this->technical_visit = $technicalVisit;
        return $this;
    }

    /**
     * Get technicalVisit
     *
     * @return timestamp $technicalVisit
     */
    public function getTechnicalVisit()
    {
        return $this->technical_visit;
    }

    /**
     * Set insurance
     *
     * @param timestamp $insurance
     * @return $this
     */
    public function setInsurance( $insurance)
    {
        $this->insurance = $insurance;
        return $this;
    }

    /**
     * Get insurance
     *
     * @return timestamp $insurance
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * Set vignettes
     *
     * @param timestamp $vignettes
     * @return $this
     */
    public function setVignettes( $vignettes)
    {
        $this->vignettes = $vignettes;
        return $this;
    }

    /**
     * Get vignettes
     *
     * @return timestamp $vignettes
     */
    public function getVignettes()
    {
        return $this->vignettes;
    }

    /**
     * Set box
     *
     * @param Box $box
     * @return $this
     */
    public function setBox( $box)
    {
        $this->box = $box;
        return $this;
    }

    /**
     * Get box
     *
     * @return Box $box
     */
    public function getBox()
    {
        return $this->box;
    }


    /**
     * Set driver
     *
     * @param Driver $driver
     * @return $this
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * Get driver
     *
     * @return Driver $driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set flot
     *
     * @param fleet $flot
     * @return $this
     */
    public function setFlot(fleet $flot)
    {
        $this->flot = $flot;
        return $this;
    }

    /**
     * Get flot
     *
     * @return ApiGps fleet $flot
     */
    public function getFlot()
    {
        return $this->flot;
    }
    public function __construct()
    {
        $this->marks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add mark
     *
     * @param Mark $mark
     */
    public function addMark(Mark $mark)
    {
        $this->marks[] = $mark;
    }

    /**
     * Remove mark
     *
     * @param Mark $mark
     */
    public function removeMark(Mark $mark)
    {
        $this->marks->removeElement($mark);
    }

    /**
     * Get marks
     *
     * @return \Doctrine\Common\Collections\Collection $marks
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * Set installation
     *
     * @param ApiGps\AdministrationBundle\Document\installation $installation
     * @return $this
     */
    public function setInstallation(\ApiGps\AdministrationBundle\Document\installation $installation)
    {
        $this->installation = $installation;
        return $this;
    }

    /**
     * Get installation
     *
     * @return ApiGps\AdministrationBundle\Document\installation $installation
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Add alter
     *
     * @param ApiGps\AdministrationBundle\Document\Alert $alter
     */
    public function addAlter(\ApiGps\AdministrationBundle\Document\Alert $alter)
    {
        $this->alters[] = $alter;
    }

    /**
     * Remove alter
     *
     * @param ApiGps\AdministrationBundle\Document\Alert $alter
     */
    public function removeAlter(\ApiGps\AdministrationBundle\Document\Alert $alter)
    {
        $this->alters->removeElement($alter);
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
