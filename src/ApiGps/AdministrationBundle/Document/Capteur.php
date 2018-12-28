<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 27/11/2018
 * Time: 19:55
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document
 */
class Capteur
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @MongoDB\Field(type="string")
     */
    private $key1;

    /**
     * @MongoDB\Field(type="string")
     */
    private $key2;

    /**
     * @MongoDB\Field(type="string")
     */
    private $ioement;

    /**
     * @MongoDB\Field(type="string")
     */
    private $valeur1;

    /**
     * @MongoDB\Field(type="string")
     */
    private $valeur2;

    /**
     * @MongoDB\Field(type="string")
     */
    private $nom;

    /**
     * @MongoDB\Field(type="string")
     */
    private $description;



    /**
     * @MongoDB\ReferenceMany(targetDocument="Vehicle", inversedBy="capteurs")
     */
    private $objets;

    /**
     * Capteur constructor.
     */
    public function __construct()
    {

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
    public function getIoement()
    {
        return $this->ioement;
    }

    /**
     * @param mixed $ioement
     */
    public function setIoement($ioement)
    {
        $this->ioement = $ioement;
    }

    /**
     * @return mixed
     */
    public function getValeur1()
    {
        return $this->valeur1;
    }

    /**
     * @param mixed $valeur1
     */
    public function setValeur1($valeur1)
    {
        $this->valeur1 = $valeur1;
    }

    /**
     * @return mixed
     */
    public function getValeur2()
    {
        return $this->valeur2;
    }

    /**
     * @param mixed $valeur2
     */
    public function setValeur2($valeur2)
    {
        $this->valeur2 = $valeur2;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



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
        //array_push($this->objets,$objets);
        $this->objets = $objets;
        //$this->objets->add($objets);
    }
    /**
     * Add objet
     *
     * @param Vehicle $objet
     */
    public function addObjets(Vehicle $objets)
    {
        $this->objets[] = $objets;
    }

    /**
     * Remove vehicle
     *
     * @param Vehicle $vehicle
     */
    public function removeVehicle(Vehicle $vehicle)
    {
        $this->vehicles->removeElement($vehicle);
    }

    /**
     * @return mixed
     */
    public function getKey1()
    {
        return $this->key1;
    }

    /**
     * @param mixed $key1
     */
    public function setKey1($key1)
    {
        $this->key1 = $key1;
    }

    /**
     * @return mixed
     */
    public function getKey2()
    {
        return $this->key2;
    }

    /**
     * @param mixed $key2
     */
    public function setKey2($key2)
    {
        $this->key2 = $key2;
    }




}