<?php

namespace queasy\config;

trait ConfigTrait
{

    private static function config()
    {
        $className = __CLASS__;

        return Provider::getInstance()->$className;
    }

}

