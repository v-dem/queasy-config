<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

use queasy\helper\Arrays;
use queasy\helper\Strings;

use queasy\config\loader\ConfigLoaderException;
use queasy\config\loader\LoaderFactory;

/**
 * Main configuration class
 */
class Config extends AbstractConfig
{
    const DEFAULT_PATH = 'queasy-config.php';

    const QUEASY_MARKER = '@queasy:';

    /**
     * Constructor.
     *
     * @param string|array|null $data Array with configuration data, or path to a config file, or null to load config from path
     *      specified by QUEASY_CONFIG_PATH constant if present, or from default path
     *
     * @throws InvalidPathException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function __construct($data = null, ConfigInterface $parent = null, $isLoadImmediately = false)
    {
        if (null === $data) {
            $data = (defined('QUEASY_CONFIG_PATH'))
                ? QUEASY_CONFIG_PATH
                : static::DEFAULT_PATH;

            if (!is_file($data) && !is_link($data)) {
                $data = array();
            }
        } elseif (!is_string($data)
                && !is_array($data)) {
            throw new InvalidPathException(gettype($data));
        }

        parent::__construct($data, $parent);

        if ($isLoadImmediately) {
            $this->data();
        }
    }

    /**
     * Get an option value from configuration by option name provided like a object property.
     *
     * @param string $name Config option name
     *
     * @return mixed|null Option value or null if $name is missing in config
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Not implemented.
     *
     * @throws ReadOnlyException
     */
    #[\ReturnTypeWillChange]
    public function __set($name, $value)
    {
        throw new ReadOnlyException(__METHOD__);
    }

    /**
     * Check if $name option is present.
     *
     * @param string $name Config option name
     *
     * @return boolean True if present, false if not
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function __isset($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * Not implemented.
     *
     * @throws ReadOnlyException
     */
    #[\ReturnTypeWillChange]
    public function __unset($name)
    {
        throw new ReadOnlyException(__METHOD__);
    }

    /**
     * Get an option value from configuration by option name or return default value if provided or return null.
     *
     * @param string $name Config option name
     * @param mixed $default Value to be returned if $name option is missing
     *
     * @return mixed Option value or $default if $name option is missing in config
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    public function get($name, $default = null)
    {
        if (isset($this[$name])) {
            return $this[$name];
        }

        if (is_array($default)) {
            $className = get_class($this);

            return new $className($default, $this);
        }

        return $default;
    }

    /**
     * Get an option value from configuration by option name.
     *
     * @param string $name Config option name
     *
     * @return mixed Option value
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     * @throws MissingOptionException When $name option is missing
     */
    public function need($name)
    {
        if (isset($this[$name])) {
            return $this[$name];
        }

        throw new MissingOptionException($name);
    }

    /**
     * Move config array pointer to the beginning.
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $data = &$this->data();

        reset($data);
    }

    /**
     * Get current config array item.
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        $data = &$this->data();

        return $this->item(current($data));
    }

    /**
     * Move to the next config array item and return it.
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        $data = &$this->data();

        return $this->item(next($data));
    }

    /**
     * Return current config array key.
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        $data = &$this->data();

        return key($data);
    }

    /**
     * Validate current config array key.
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
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
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
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
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($name)
    {
        $data = &$this->data();

        $parent = $this->parent();

        if (isset($data[$name]) || array_key_exists($name, $data)) {
            return true;
        }

        if (null === $parent) {
            return false;
        }

        return $parent->offsetExists($name);
    }

    /**
     * Get an option value from config by option $name or throw ConfigException if option is missing.
     *
     * @param string $name Config option name
     *
     * @return mixed Config option value
     *
     * @throws ConfigLoaderException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($name)
    {
        if ($this->offsetExists($name)) {
            $data = &$this->data();
            if (isset($data[$name]) || array_key_exists($name, $data)) {
                return $this->item($data[$name]);
            }

            $parent = $this->parent();

            return (null === $parent)? null: $parent[$name];
        }

        return null;
    }

    /**
     * Not implemented.
     *
     * @throws BadMethodCallException
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($name)
    {
        throw new ReadOnlyException(__METHOD__);
    }

    /**
     * Not implemeted.
     *
     * @throws BadMethodCallException
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($name, $value)
    {
        throw new ReadOnlyException(__METHOD__);
    }

    /**
     * Search for config keys using regular expression.
     *
     * @param string $regex Regular expression
     *
     * @return ConfigInterface Config instance containing key/option pairs found.
     */
    public function regex($regex)
    {
        $data = &$this->data();

        $options = array();
        foreach ($data as $key => $value) {
            if (preg_match($regex, $key)) {
                $options[$key] = $value;
            }
        }

        $className = get_class($this);

        return new $className($options);
    }

    public function merge($array)
    {
        $data = Arrays::merge($this->data(), $array);

        $this->setData($data);
    }

    /**
     * Convert all configuration structure into a regular array.
     *
     * @return array Configuration represented as a regular array
     *
     * @throws ConfigLoaderException When any of included configuration files are missing or corrupted (doesn't return an array)
     */
    public function toArray()
    {
        $result = array();
        foreach ($this->data() as $key => $item) {
            $item = $this->item($item);

            $result[$key] = (is_object($item) && ($item instanceof ConfigInterface))
                ? $item->toArray()
                : $result[$key] = $item;
        }

        return $result;
    }

    /**
     * Check if data is loaded, and try to load it using loader if not.
     *
     * @return &array A reference to array containing config
     *
     * @throws ConfigLoaderException When configuration load attempt fails,
     *          in case of missing or corrupted (doesn't returning an array) file
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
     * Check if $item is an array and if yes return ConfigInterface instance that encapsulates this array,
     * if $item is instance of ConfigInterface, set $this as his parent, in other way return $item as is.
     * If $item starts with "@queasy:" then run eval() for the rest of the string (to support multi-file configs
     * for formats other than PHP)
     *
     * @param mixed $item An item to check
     *
     * @return ConfigInterface|mixed ConfigInterface instance if $item was an array, or $item as is
     */
    protected function item($item)
    {
        if (is_array($item)) {
            $className = get_class($this);

            $item = new $className($item, $this);
        } elseif ($item instanceof ConfigInterface) {
            $item->setParent($this);
        } elseif (is_string($item) && Strings::startsWith($tritem = trim($item), self::QUEASY_MARKER)) {
            $item = eval('return ' . substr($tritem, strlen(self::QUEASY_MARKER)) . (Strings::endsWith($tritem, ';')? '': ';'));
        }

        return $item;
    }
}

