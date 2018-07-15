<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 04/06/2018
 * Time: 04:24
 */
namespace ApiGps\EspaceUserBundle\Document;
use FOS\OAuthServerBundle\Document\AccessToken as BaseAccessToken;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class AccessToken extends BaseAccessToken
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
