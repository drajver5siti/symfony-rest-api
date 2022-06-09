<?php

namespace App\Managers;

use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class DefaultManager
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Manager();
            // self::$instance->setSerializer(new JsonApiSerializer());

            if (isset($_GET['include'])) {
                self::$instance->parseIncludes($_GET['include']);
            }

            /*
                JsonApiSerializer
                ArraySerializer
                DataArraySerializer - default

            */
        }
        return self::$instance;
    }
}
