<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

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
     *      specified by QUEASY_CONFIG_PATH constant if present, or from default path
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
            throw InvalidArgumentException::invalidArgumentType(gettype($data));
        }

        parent::__construct($data, $parent);
    }

    /**
     * Get an option value from configuration by option name provided like a object property.
     *
     * @param string $name Config option name
     *
     * @return mixed|null Option value or null if $name is missing in config
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Check if $name option is present.
     *
     * @param string $name Config option name
     *
     * @return boolean True if present, false if not
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function __isset($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * Not implemented.
     *
     * @param string $name Config option name
     *
     * @throws BadMethodCallException
     */
    public function __unset($name)
    {
        $data = $this->data();

        unset($data[$name]);

        // throw BadMethodCallException::notImplemented(__METHOD__);
    }

    /**
     * Get an option value from configuration by option name or return default value if provided or return null.
     *
     * @param string $name Config option name
     * @param mixed $default Value to be returned if $name option is missing
     *
     * @return mixed Option value or $default if $name option is missing in config
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function get($name, $default = null)
    {
        if (isset($this[$name])) {
            return $this[$name];
        }

        return $default;
    }

    /**
     * Move config array pointer to the beginning.
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function rewind()
    {
        $data = &$this->data();

        reset($data);
    }

    /**
     * Get current config array item.
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function current()
    {
        $data = &$this->data();

        return $this->item(current($data));
    }

    /**
     * Move to the next config array item and return it.
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function next()
    {
        $data = &$this->data();

        return $this->item(next($data));
    }

    /**
     * Return current config array key.
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function key()
    {
        $data = &$this->data();

        return key($data);
    }

    /**
     * Validate current config array key.
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function valid()
    {
        $data = &$this->data();

        $key = key($data);

        return ($key !== null)
            && ($key !== false);
    }

    /**
     * Return number of items in a current configuration level.
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
     * Check if $name option is present.
     *
     * @param string $name Config option name
     *
     * @return boolean True if present, false if not
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function offsetExists($name)
    {
        $data = &$this->data();

        $parent = $this->parent();

        if (isset($data[$name]) || array_key_exists($name, $data)) {
            return true;
        } elseif (is_null($parent)) {
            return false;
        } else {
            return $parent->offsetExists($name);
        }
    }

    /**
     * Get an option value from config by option $name or throw ConfigException if option is missing.
     *
     * @param string $name Config option name
     *
     * @return mixed Config option value
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     *                          or when $name option is missing in config (and in its parent configs)
     */
    public function offsetGet($name)
    {
        if ($this->offsetExists($name)) {
            $data = &$this->data();
            if (array_key_exists($name, $data)) {
                return $this->item($data[$name]);
            } else {
                $parent = $this->parent();

                return is_null($parent)? null: $parent[$name];
            }
        } else {
            throw ConfigException::missingOption($name);
        }
    }

    /**
     * Convert all configuration structure into a regular array.
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
     * Check if data is loaded, and try to load it using loader if not.
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
     * Check if $item is an array and if yes returns ConfigInterface instance that encapsulates this array, in other way returns $item as is.
     *
     * @param mixed $item An item to check
     *
     * @return ConfigInterface|mixed ConfigInterface instance if $item was an array or $item as is
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

