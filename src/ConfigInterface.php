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
     * Get a value from configuration by key provided or return $default value or null if $default not set
     *
     * @param string $key Configuration key
     * @param mixed $default Value to be returned if $key is missing
     *
     * @return mixed Value or $default if $key is missing in config
     */
    function get($key, $default = null);

    /**
     * Convert all configuration structure into a regular array
     *
     * @return array Configuration represented as a regular array
     */
    function toArray();
}

