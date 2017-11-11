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
 * Configuration loader class
 */
class Loader extends AbstractLoader
{

    /**
     * @var string Path to config file
     */
    private $path;

    /**
     * Constructor.
     *
     * @param string Path to config file
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Loads and returns an array containing configuration.
     *
     * @return array Loaded configuration
     */
    public function load()
    {
        if (!file_exists($this->path)) {
            throw new ConfigException(sprintf('Config path "%s" not found.', $this->path));
        }

        $data = include($this->path);
        if (!is_array($data)) {
            throw new ConfigException(sprintf('Config file "%s" is corrupted.', $this->path));
        }

        return $data;
    }

}

