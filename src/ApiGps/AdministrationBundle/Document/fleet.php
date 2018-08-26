<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 24/08/2018
 * Time: 11:19
 */

namespace ApiGps\AdministrationBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class fleet
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /** @MongoDB\ReferenceOne(targetDocument="Company", inversedBy="fllets") */
    private $comapny;

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
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set comapny
     *
     * @param Company $comapny
     * @return $this
     */
    public function setComapny(Company $comapny)
    {
        $this->comapny = $comapny;
        return $this;
    }

    /**
     * Get comapny
     *
     * @return Company $comapny
     */
    public function getComapny()
    {
        return $this->comapny;
    }
}
