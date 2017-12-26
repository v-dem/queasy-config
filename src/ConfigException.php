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
    /**
     * Create exception for not found config case.
     *
     * @param string $path Path to config file
     *
     * @return ConfigException Exception instance
     */
    public static function fileNotFound($path)
    {
        return new ConfigException(sprintf('Config file "%s" not found.', $path));
    }

    /**
     * Create exception for not readable config case.
     *
     * @param string $path Path to config file
     *
     * @return ConfigException Exception instance
     */
    public static function fileNotReadable($path)
    {
        return new ConfigException(sprintf('Config file "%s" cannot be read.', $path));
    }

    /**
     * Create exception for corrupted config case.
     *
     * @param string $path Path to config file
     *
     * @return ConfigException Exception instance
     */
    public static function fileIsCorrupted($path)
    {
        return new ConfigException(sprintf('Config file "%s" is corrupted.', $path));
    }

    /**
     * Create exception for loader already registered case.
     *
     * @param string $pattern Regex pattern of registered loader
     *
     * @return ConfigException Exception instance
     */
    public static function loaderAlreadyRegistered($pattern)
    {
        return new ConfigException(sprintf('Custom loader for pattern "%s" already registered.', $pattern));
    }

    /**
     * Create exception for unknown loader case.
     *
     * @param string $path Path to config file
     *
     * @return ConfigException Exception instance
     */
    public static function loaderNotFound($path)
    {
        return new ConfigException(sprintf('No loader found for path "%s".', $path));
    }

    /**
     * Create exception for missing config key case.
     *
     * @param string $name Config option name
     *
     * @return ConfigException Exception instance
     */
    public static function missingOption($name)
    {
        return new ConfigException(sprintf('Missing config option "%s".', $name));
    }
}

