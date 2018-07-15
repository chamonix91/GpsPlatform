<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 04/06/2018
 * Time: 04:25
 */
namespace ApiGps\EspaceUserBundle\Document;
use FOS\OAuthServerBundle\Document\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @MongoDB\Document
 */
class RefreshToken extends BaseRefreshToken
{
    /**
     * @MongoDB\Id
     */
    protected $id;


    /** @MongoDB\ReferenceOne(targetDocument="Client") */
    protected $client;


    /** @MongoDB\ReferenceOne(targetDocument="User") */
    protected $user;
}
