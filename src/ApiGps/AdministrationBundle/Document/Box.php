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
    private $imei;

    /**
     * @MongoDB\Field(type="string")
     */
    private $ass_sim;

    /**
     * @MongoDB\Field(type="string")
     */
    private $client_sim;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $buy_date;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $bond_date;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $endbond_date;

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
    private $type;
    /**
     * @MongoDB\Field(type="boolean")
     */
    private $active;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $retrait_date;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Vehicle",inversedBy="box")
     */
    private $vehicle;

    /** @MongoDB\ReferenceOne(targetDocument="Company", inversedBy="boxes") */
    private $company;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Subscription",mappedBy="box")
     */
    public $subscription;

    /**
     * @MongoDB\ReferenceOne(targetDocument="installation",mappedBy="box")
     */
    public $installation;

    /**
     * @return mixed
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param mixed $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }


    /**
     * @MongoDB\ReferenceMany(targetDocument="Trame",mappedBy="box")
     */
    private $trame;

    public function __construct()
    {
        $this->trame = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set assSim
     *
     * @param string $assSim
     * @return $this
     */
    public function setAssSim($assSim)
    {
        $this->ass_sim = $assSim;
        return $this;
    }

    /**
     * Get assSim
     *
     * @return string $assSim
     */
    public function getAssSim()
    {
        return $this->ass_sim;
    }

    /**
     * Set clientSim
     *
     * @param string $clientSim
     * @return $this
     */
    public function setClientSim($clientSim)
    {
        $this->client_sim = $clientSim;
        return $this;
    }

    /**
     * Get clientSim
     *
     * @return string $clientSim
     */
    public function getClientSim()
    {
        return $this->client_sim;
    }

    /**
     * Set buyDate
     *
     * @param timestamp $buyDate
     * @return $this
     */
    public function setBuyDate( $buyDate)
    {
        $this->buy_date = $buyDate;
        return $this;
    }

    /**
     * Get buyDate
     *
     * @return timestamp $buyDate
     */
    public function getBuyDate()
    {
        return $this->buy_date;
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
     * Get model
     *
     * @return string $model
     */
    public function getModel()
    {
        return $this->model;
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

    /**
     * Set retraitDate
     *
     * @param timestamp $retraitDate
     * @return $this
     */
    public function setRetraitDate( $retraitDate)
    {
        $this->retrait_date = $retraitDate;
        return $this;
    }

    /**
     * Get retraitDate
     *
     * @return timestamp $retraitDate
     */
    public function getRetraitDate()
    {
        return $this->retrait_date;
    }

    /**
     * Add trame
     *
     * @param Trame $trame
     */
    public function addTrame(Trame $trame)
    {
        $this->trame[] = $trame;
    }

    /**
     * Remove trame
     *
     * @param Trame $trame
     */
    public function removeTrame(Trame $trame)
    {
        $this->trame->removeElement($trame);
    }

    /**
     * Get trame
     *
     * @return \Doctrine\Common\Collections\Collection $trame
     */
    public function getTrame()
    {
        return $this->trame;
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
     * Set subscription
     *
     * @param ApiGps\AdministrationBundle\Document\Subscription $subscription
     * @return $this
     */
    public function setSubscription(\ApiGps\AdministrationBundle\Document\Subscription $subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * Get subscription
     *
     * @return ApiGps\AdministrationBundle\Document\Subscription $subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
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
}
