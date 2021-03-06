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
     * Call class instance as a function.
     *
     * @param string $name Option name
     * @param string $default Default option value (optional)
     *
     * @return mixed Option value or $default if $name option is missing
     */
    function __invoke($name, $default = null)
    {
        return (1 === func_num_args())
            ? $this->need($name)
            : $this->get($name, $default);
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

