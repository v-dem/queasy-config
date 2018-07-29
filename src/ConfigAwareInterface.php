<?php

namespace queasy\config;

/**
 * Describes a config-aware instance.
 */
interface ConfigAwareInterface
{
    /**
     * Sets a config instance on the object.
     *
     * @param ConfigInterface $config
     *
     * @return void
     */
    public function setConfig(ConfigInterface $config);
}

