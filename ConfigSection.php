<?php

namespace queasy\config;

class ConfigSection
{

    private $config;

    public function __construct($config)
    {
        if (is_array($config)) {
            $this->config = $config;

            return;
        } elseif (@file_exists($config)) {
            $this->config = @include_once($config);
            if (is_array($this->config)) {
                return;
            }
        }

        throw new ConfigException(sprintf('Configuration file "%s" is corrupted.', $config));
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function get($key, $default = null)
    {
        return isset($this->config[$key])? $this->config[$key]: $default;
    }

    public function getMandatory($key)
    {
        if (!isset($this->config[$key])) {
            throw new ConfigException(sprintf('Mandatory configuration key "%s" is missing.', $key));
        }

        return $this->get($key);
    }

}

