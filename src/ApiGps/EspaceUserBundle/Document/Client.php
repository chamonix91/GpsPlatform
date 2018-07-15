<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 04/06/2018
 * Time: 04:23
 */
namespace ApiGps\EspaceUserBundle\Document;
use FOS\OAuthServerBundle\Document\Client as BaseClient;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Client extends BaseClient
{
    /**
     * @MongoDB\Id(strategy="AUTO")
     */
    protected $id;

}
