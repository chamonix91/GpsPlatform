<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 17/10/2018
 * Time: 23:13
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;



/**
 * @MongoDB\Document
 */
class Installation
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $affectation_date;
    /**
     * @MongoDB\Field(type="timestamp")
     */
    private $creation_date;
    /**
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @MongoDB\Field(type="string")
     */
    private $note;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $status;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image1;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image2;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image3;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image4;




    /**
     * @MongoDB\ReferenceOne(targetDocument="Vehicle",inversedBy="installation")
     */
    private $vehicle;
    /**
     * @MongoDB\ReferenceOne(targetDocument="Vehicle",inversedBy="installation2")
     */
    private $vehicle2;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Box",mappedBy="installation")
     */
    public $box;

    /**
     * @MongoDB\ReferenceOne(targetDocument="ApiGps\EspaceUserBundle\Document\User",inversedBy="installation")
     */
    private $installateur;









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
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
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
     * Set box
     *
     * @param Box $box
     * @return $this
     */
    public function setBox(Box $box)
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
     * Set affectationDate
     *
     * @param timestamp $affectationDate
     * @return $this
     */
    public function setAffectationDate($affectationDate)
    {
        $this->affectation_date = $affectationDate;
        return $this;
    }

    /**
     * Get affectationDate
     *
     * @return timestamp $affectationDate
     */
    public function getAffectationDate()
    {
        return $this->affectation_date;
    }

    /**
     * @return mixed
     */
    public function getVehicle2()
    {
        return $this->vehicle2;
    }

    /**
     * @param mixed $vehicle2
     */
    public function setVehicle2($vehicle2)
    {
        $this->vehicle2 = $vehicle2;
    }

    /**
     * Set installateur
     *
     * @param ApiGps\EspaceUserBundle\Document\User $installateur
     * @return $this
     */
    public function setInstallateur(\ApiGps\EspaceUserBundle\Document\User $installateur)
    {
        $this->installateur = $installateur;
        return $this;
    }

    /**
     * Get installateur
     *
     * @return ApiGps\EspaceUserBundle\Document\User $installateur
     */
    public function getInstallateur()
    {
        return $this->installateur;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return $this
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return string $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }



    /**
     * Set image1
     *
     * @param string $image1
     * @return $this
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;
        return $this;
    }

    /**
     * Get image1
     *
     * @return string $image1
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set image2
     *
     * @param string $image2
     * @return $this
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
        return $this;
    }

    /**
     * Get image2
     *
     * @return string $image2
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set image3
     *
     * @param string $image3
     * @return $this
     */
    public function setImage3($image3)
    {
        $this->image3 = $image3;
        return $this;
    }

    /**
     * Get image3
     *
     * @return string $image3
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * Set image4
     *
     * @param string $image4
     * @return $this
     */
    public function setImage4($image4)
    {
        $this->image4 = $image4;
        return $this;
    }

    /**
     * Get image4
     *
     * @return string $image4
     */
    public function getImage4()
    {
        return $this->image4;
    }
}
