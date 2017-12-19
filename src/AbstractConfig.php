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
     * Gets a value from configuration by key provided like a object property.
     *
     * @param string $key Configuration key
     *
     * @return mixed Value or $default if $key is missing in config
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Sets config data
     *
     * @param mixed $data Config data
     */
    protected function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Returns config data
     *
     * @return &mixed Config data
     */
    protected function &data()
    {
        return $this->data;
    }

    /**
     * Sets parent configuration object.
     *
     * @param ConfigInterface|null $parent Parent config instance
     */
    protected function setParent(ConfigInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Returns parent configuration object.
     *
     * @return ConfigInterface|null Parent config instance or null
     */
    protected function parent()
    {
        return $this->parent;
    }
}

