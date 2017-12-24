<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\loader;

use queasy\config\ConfigException;

/**
 * File system configuration loader class
 */
abstract class FileSystemLoader extends AbstractLoader
{
    /**
     * @var string Path to config file
     */
    private $path;

    /**
     * Constructor.
     *
     * @param string $path Path to config file
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Check if config file exists and is accessible.
     *
     * @param string Path to config file
     */
    public function check()
    {
        if (!file_exists($this->path())) {
            throw ConfigException::fileNotFound($this->path());
        }

        if (!is_readable($this->path())) {
            throw ConfigException::fileNotReadable($this->path());
        }
    }

    /**
     * Return config path.
     *
     * @param string Path to config file
     */
    protected function path()
    {
        return $this->path;
    }
}

