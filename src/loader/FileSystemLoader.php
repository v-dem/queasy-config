<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\loader;

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
     *
     * @return bool True if config file can be accessed
     *
     * @throws ConfigLoaderException On error (file not found or can't be read)
     */
    public function check()
    {
        if (!is_file($this->path()) && !is_link($this->path())) {
            throw new NotFoundException($this->path());
        }

        if (!is_readable($this->path())) {
            throw new NotReadableException($this->path());
        }

        return true;
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

