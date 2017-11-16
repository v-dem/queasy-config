<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

/**
 * Configuration interface
 */
interface ConfigInterface extends \Iterator, \ArrayAccess, \Countable
{

    function createLoader();

    /**
     * Gets a value from configuration by key provided
     *
     * @param string $key Configuration key
     * @param mixed $default Value to be returned if $key is missing
     *
     * @return mixed Value or $default if $key is missing in config
     */
    function get($key, $default = null);

    /**
     * Gets a value from configuration by key provided or throws ConfigException if key is missing
     *
     * @param string $key Configuration key
     *
     * @return mixed Value
     */
    function need($key);

    /**
     * Converts all configuration structure into a regular array
     *
     * @return array Configuration represented as a regular array
     */
    function toArray();

}

