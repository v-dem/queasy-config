<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

use Exception;

/**
 * Configuration exception class
 */
class ConfigException extends Exception
{
    public static function fileNotFound($path)
    {
        return new ConfigException(sprintf('Config file "%s" not found.', $path));
    }

    public static function fileNotReadable($path)
    {
        return new ConfigException(sprintf('Config file "%s" cannot be read.', $path));
    }

    public static function fileIsCorrupted($path)
    {
        return new ConfigException(sprintf('Config file "%s" is corrupted.', $path));
    }

    public static function loaderAlreadyRegistered($pattern)
    {
        return new ConfigException(sprintf('Custom loader for pattern "%s" already registered.', $pattern));
    }

    public static function loaderNotFound($path)
    {
        return new ConfigException(sprintf('No loader found for path "%s".', $path));
    }

    public static function missingKey($key)
    {
        return new ConfigException(sprintf('Missing config key "%s".', $key));
    }
}

