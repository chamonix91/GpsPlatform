<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 28/11/2018
 * Time: 11:34
 */

namespace ApiGps\AdministrationBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Sonde
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $bu;

    /**
     * @MongoDB\Field(type="string")
     */
    private $ru;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Vehicle", inversedBy="sondes")
     */
    private $objets;

    /**
     * @return mixed
     */
    public function getObjets()
    {
        return $this->objets;
    }

    /**
     * @param mixed $objets
     */
    public function setObjets($objets)
    {
        $this->objets = $objets;
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
    public function getBu()
    {
        return $this->bu;
    }

    /**
     * @param mixed $bu
     */
    public function setBu($bu)
    {
        $this->bu = $bu;
    }

    /**
     * @return mixed
     */
    public function getRu()
    {
        return $this->ru;
    }

    /**
     * @param mixed $ru
     */
    public function setRu($ru)
    {
        $this->ru = $ru;
    }



}