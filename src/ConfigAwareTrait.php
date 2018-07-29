<?php

namespace queasy\config;

/**
 * Basic Implementation of ConfigAwareInterface.
 */
trait ConfigAwareTrait
{
    /**
     * The config instance.
     *
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Sets a config.
     *
     * @param ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }
}

