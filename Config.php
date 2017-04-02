<?php

namespace queasy\config;

class Config
{

    const DEFAULT_PATH = 'queasy-config.php';

    private static $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $configs = null;

    private function __construct()
    {
        if (defined('QUEASY_CONFIG_PATH')) {
            $this->load(QUEASY_CONFIG_PATH);
        } else {
            $this->load(self::DEFAULT_PATH);
        }
    }

    public function __get($section)
    {
        return $this->get($section);
    }

    public function get($section)
    {
        if (!$this->configs) {
            throw new ConfigException('Configuration was not loaded.');
        }

        if (!isset($this->configs[$section])) {
            throw new ConfigException(sprintf('Configuration section "%s" is missing.', $section));
        }

        return $this->configs[$section];
    }

    private function load($path)
    {
        if (!@file_exists($path)) {
            throw new ConfigException('Cannot find configuration file.');
        }

        $config = @include_once($path);
        if (false === $config) {
            throw new ConfigException(sprintf('Configuration file "%s" is corrupted.', $path));
        }

        $this->configs = $config;
    }

}

