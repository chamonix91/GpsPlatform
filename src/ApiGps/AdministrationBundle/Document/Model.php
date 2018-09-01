<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 31/08/2018
 * Time: 15:38
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * @MongoDB\Document
 */
class Model
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /** @MongoDB\ReferenceOne(targetDocument="Mark", inversedBy="models") */
    private $mark;





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
     * Set mark
     *
     * @param Mark $mark
     * @return $this
     */
    public function setMark(Mark $mark)
    {
        $this->mark = $mark;
        return $this;
    }

    /**
     * Get mark
     *
     * @return Mark $mark
     */
    public function getMark()
    {
        return $this->mark;
    }
}
