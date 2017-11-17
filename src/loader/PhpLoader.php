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
 * Standard (PHP-based) configuration loader class
 */
class PhpLoader extends FileSystemLoader
{

    /**
     * Loads and returns an array containing configuration.
     *
     * @return array Loaded configuration
     */
    public function load()
    {
        $path = $this->path();

        try {
            $data = include($path);
        } catch (\Throwable $e) {
            throw new ConfigException(sprintf('Config file "%s" is corrupted.', $path));
        }

        if (!is_array($data)) {
            throw new ConfigException(sprintf('Config file "%s" is corrupted.', $path));
        }

        return $data;
    }

}

