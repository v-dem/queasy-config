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
    /**
     * Get an option value from configuration by name provided or return $default value or null if $default not set.
     *
     * @param string $name Config option name
     * @param mixed $default Value to be returned if option $name is missing
     *
     * @return mixed|null Option value or $default if $name option is missing
     */
    function get($name, $default = null);

    /**
     * Get an option value from configuration by option name provided like a object property.
     *
     * @param string $name Option name
     *
     * @return mixed|null Option value or null if option is missing
     */
    function __get($name);

    /**
     * Check if an option exists in config.
     *
     * @param string $name Option name
     *
     * @return bool True if an option exists, false otherwise
     */
    function __isset($name);

    /**
     * Convert all configuration structure into a regular array.
     *
     * @return array Configuration represented as a regular array
     */
    function toArray();
}

