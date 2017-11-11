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
     * Gets a value from configuration by key provided
     *
     * @param string $key Configuration key
     * @param mixed $default Value to be returned if $key is missing
     *
     * @return mixed Value or $default if $key is missing in config
     */
    public function get($key, $default = null);

    /**
     * Gets a value from configuration by key provided or throws ConfigException if key is missing
     *
     * @param string $key Configuration key
     *
     * @return mixed Value
     */
    public function need($key);

    /**
     * Converts all configuration structure into a regular array
     *
     * @return array Configuration represented as a regular array
     */
    public function toArray();

}

