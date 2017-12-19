<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

use BadMethodCallException;
use InvalidArgumentException;

use queasy\config\loader\LoaderFactory;

/**
 * Main configuration class
 */
class Config extends AbstractConfig
{
    const DEFAULT_PATH = 'queasy-config.php';

    /**
     * Constructor.
     *
     * @param string|array|null $data Array with configuration data, or path to a config file, or null to load config from path
     *                                specified by QUEASY_CONFIG_PATH constant if present, or from default path
     *
     * @return mixed Value or $default if $key is missing in config
     *
     * @throws InvalidArgumentException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function __construct($data = null, ConfigInterface $parent = null)
    {
        if (is_null($data)) {
            if (defined('QUEASY_CONFIG_PATH')) {
                $data = QUEASY_CONFIG_PATH;
            } else {
                $data = static::DEFAULT_PATH;
            }
        } else if (!is_string($data)
                && !is_array($data)) {
            throw new InvalidArgumentException('Invalid argument type. Only NULL, String or Array allowed.');
        }

        parent::__construct($data, $parent);
    }

    /**
     * Gets a value from configuration by key provided like a object property.
     *
     * @param string $key Configuration key
     *
     * @return mixed Value or $default if $key is missing in config
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Gets a value from configuration by key provided.
     *
     * @param string $key Configuration key
     * @param mixed $default Value to be returned if $key is missing
     *
     * @return mixed Value or $default if $key is missing in config
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function get($key, $default = null)
    {
        $value = $this[$key];

        return is_null($value)? $default: $value;
    }

    /**
     * Gets a value from configuration by key provided or throws ConfigException if key is missing.
     *
     * @param string $key Configuration key
     *
     * @return mixed Value
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function need($key)
    {
        if (!isset($this[$key])) {
            throw new ConfigException(sprintf('Mandatory config key "%s" is missing.', $key));
        }

        return $this[$key];
    }

    public function rewind()
    {
        $data = &$this->data();

        reset($data);
    }

    public function current()
    {
        $data = &$this->data();

        return $this->item(current($data));
    }

    public function next()
    {
        $data = &$this->data();

        return $this->item(next($data));
    }

    public function key()
    {
        $data = &$this->data();

        return key($data);
    }

    public function valid()
    {
        $data = &$this->data();

        $key = key($data);

        return ($key !== null)
                && ($key !== false);
    }

    /**
     * Returns number of items in a current configuration level.
     *
     * @return int Number of items
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function count()
    {
        return count($this->data());
    }

    /**
     * Checks if $key is present.
     *
     * @param string $key Config key
     *
     * @return boolean True if present, false if not
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function offsetExists($key)
    {
        $data = &$this->data();
        $parent = $this->parent();

        if (array_key_exists($key, $data)) {
            return true;
        } elseif (is_null($parent)) {
            return false;
        } else {
            return $parent->offsetExists($key);
        }
    }

    /**
     * Gets a value from config by $key.
     *
     * @param string $key Config key
     *
     * @return mixed|null Config value or null if $key is missing
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function offsetGet($key)
    {
        if ($this->offsetExists($key)) {
            $data = &$this->data();
            if (array_key_exists($key, $data)) {
                return $this->item($data[$key]);
            } else {
                $parent = $this->parent();

                return is_null($parent)? null: $parent[$key];
            }
        } else {
            return null;
        }
    }

    /**
     * Not implemented.
     *
     * @throws BadMethodCallException
     */
    public function offsetSet($key, $value)
    {
        throw new BadMethodCallException('Not implemented. Config is read-only.');
    }

    /**
     * Not implemented.
     *
     * @throws BadMethodCallException
     */
    public function offsetUnset($key)
    {
        throw new BadMethodCallException('Not implemented. Config is read-only.');
    }

    /**
     * Converts all configuration structure into a regular array.
     *
     * @return array Configuration represented as a regular array
     *
     * @throws ConfigException When any of included configuration files are missing or corrupted (doesn't return an array)
     */
    public function toArray()
    {
        $result = array();
        foreach ($this->data() as $key => $item) {
            $item = $this->item($item);
            if (is_object($item)
                    && ($item instanceof ConfigInterface)) {
                $result[$key] = $item->toArray();
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }

    /**
     * Checks if data is loaded, and tries to load it using loader if not.
     *
     * @return &array An array containing config
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    protected function &data()
    {
        $data = &parent::data();
        if (is_string($data)) {
            $loader = LoaderFactory::create($data);

            $data = $loader();

            $this->setData($data);
        }

        return $data;
    }

    /**
     * Checks if $item is an array and if yes returns Config object that encapsulates this array, in other way returns $item as is.
     *
     * @param mixed $item An item to check
     *
     * @return ConfigInterface|mixed Config instance if $item was an array or $item as is
     */
    protected function item($item)
    {
        if (is_array($item)) {
            $className = get_class($this);

            return new $className($item, $this);
        } elseif ($item instanceof AbstractConfig) {
            $item->setParent($this);
        }

        return $item;
    }
}

