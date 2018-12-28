<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 24/11/2018
 * Time: 15:06
 */

namespace ApiGps\AdministrationBundle\Document;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Ioelement
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $idio;

    /**
     * @MongoDB\Field(type="string")
     */
    private $designation;
    /**
     * @MongoDB\Field(type="string")
     */
    private $label;

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
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param mixed $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getIdio()
    {
        return $this->idio;
    }

    /**
     * @param mixed $idio
     */
    public function setIdio($idio)
    {
        $this->idio = $idio;
    }





}