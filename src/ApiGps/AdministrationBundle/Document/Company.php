<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 14/07/2018
 * Time: 08:56
 */

namespace ApiGps\AdministrationBundle\Document;

use ApiGps\EspaceUserBundle\Document\User;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @MongoDB\Document
 */
class Company
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /** @MongoDB\ReferenceMany(targetDocument="ApiGps\EspaceUserBundle\Document\User", mappedBy="company") */
    private $users;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    
    /**
     * Add user
     *
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection $users
     */
    public function getUsers()
    {
        return $this->users;
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
}
