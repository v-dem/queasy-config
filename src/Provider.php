<?php

namespace queasy\config;

class Provider
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

    private $config = null;

    private function __construct($path = null)
    {
        if (is_null($path)) {
            if (defined('QUEASY_CONFIG_PATH')) {
                $path = QUEASY_CONFIG_PATH;
            } else {
                $path = self::DEFAULT_PATH;
            }
        }

        $this->load($path);
    }

    public function __get($section)
    {
        return $this->get($section);
    }

    public function get($section)
    {
        if (!$this->config) {
            throw new ConfigException('Config was not loaded.');
        }

        if (!isset($this->config[$section])) {
            throw new ConfigException(sprintf('Config section "%s" is missing.', $section));
        }

        return $this->config[$section];
    }

    private function load($path)
    {
        $loader = new Loader($path);

        $this->config = $loader();
    }

}

