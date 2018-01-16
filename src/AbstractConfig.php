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
 * Abstract configuration class
 */
abstract class AbstractConfig implements ConfigInterface
{
    /**
     * @var string|array|null Config data or path to data
     */
    private $data;

    /**
     * @var ConfigInterface|null Reference to parent config
     */
    private $parent;

    /**
     * Constructor.
     *
     * @param mixed $data Configuration data
     * @param ConfigInterface|null Parent config instance
     */
    public function __construct($data = null, ConfigInterface $parent = null)
    {
        $this->setData($data);

        $this->setParent($parent);
    }

    /**
     * Get an option value from configuration by option name provided like a object property.
     *
     * @param string $name Option name
     *
     * @return mixed|null Option value or null if option is missing
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Check if an option exists at current config level.
     *
     * @param string $name Option name
     *
     * @return bool True if $name option exists, false otherwise.
     */
    public function offsetIsset($name)
    {
        return isset($this[$name]);
    }

    /**
     * Remove an option from a current config level.
     *
     * @param string $name Option name
     */
    public function offsetUnset($name)
    {
        unset($this->data[$name]);
    }

    /**
     * Set $name config option using $value.
     *
     * @param string $name Config option name
     * @param mixed $value Config option value
     */
    public function offsetSet($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Set config data
     *
     * @param mixed $data Config data
     */
    protected function setData(&$data)
    {
        $this->data = $data;
    }

    /**
     * Return config data
     *
     * @return &mixed Config data
     */
    protected function &data()
    {
        return $this->data;
    }

    /**
     * Set parent configuration object.
     *
     * @param ConfigInterface|null $parent Parent config instance
     */
    protected function setParent(ConfigInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Return parent configuration object.
     *
     * @return ConfigInterface|null Parent config instance or null
     */
    protected function parent()
    {
        return $this->parent;
    }
}

