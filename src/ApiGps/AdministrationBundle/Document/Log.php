<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 14/10/2018
 * Time: 19:03
 */

namespace ApiGps\AdministrationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * @MongoDB\Document
 */

class log
{

    /**
     * @MongoDB\Id
     */
    protected $id;








    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
}
