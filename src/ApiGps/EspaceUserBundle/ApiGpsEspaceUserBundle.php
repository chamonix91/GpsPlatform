<?php

namespace ApiGps\EspaceUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiGpsEspaceUserBundle extends Bundle
{
    public function getParent()
    {

        return 'FOSUserBundle';
    }
}
