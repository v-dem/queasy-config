<?php

namespace queasy\config;

trait ProviderTrait
{

    private $configProvider = null;
    public static function configProvider($path = null)
    {
        if (is_null(self::$configProvider)) {
            self::$configProvider = new Provider($path);
        }

        return self::$configProvider;
    }

}

