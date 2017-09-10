<?php

namespace queasy\config;

trait ConfigTrait
{

    protected static function config()
    {
        $className = self::class;

        return Provider::getInstance()->$className;
    }

}

