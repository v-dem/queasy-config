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
     * Get an option value from configuration by name provided, or return $default, or null if $default not set.
     *
     * @param string $name Config option name
     * @param mixed|null $default Value to be returned if option $name is missing
     *
     * @return mixed Option value
     */
    function get($name, $default = null);

    /**
     * Get an option value from configuration by name provided.
     *
     * @param string $name Config option name
     *
     * @return mixed Option value or $default if $name option is missing
     *
     * @throws ConfigException When $name option is missing
     */
    function need($name);

    /**
     * Get an option value from configuration by option name provided like a object property.
     *
     * @param string $name Option name
     *
     * @return mixed|null Option value or null if option is missing
     */
    function __get($name);

    /**
     * Set an option value.
     *
     * @param string $name Option name
     * @param mixed $value Option value
     */
    function __set($name, $value);

    /**
     * Check if an option exists in config.
     *
     * @param string $name Option name
     *
     * @return bool True if an option exists, false otherwise
     */
    function __isset($name);

    /**
     * Unset option in config.
     *
     * @param string $name Option name
     */
    function __unset($name);

    /**
     * Call class instance as a function.
     *
     * @param string $name Option name
     * @param string $default Default option value (optional)
     *
     * @return mixed Option value or $default if $name option is missing
     */
    function __invoke($name, $default = null);

    /**
     * Search for config keys using regular expression.
     *
     * @param string $regex Regular expression
     *
     * @return ConfigInterface Config instance containing key/option pairs found.
     */
    public function regex($regex);

    /**
     * Convert all configuration structure into a regular array.
     *
     * @return array Configuration represented as a regular array
     */
    function toArray();
}

