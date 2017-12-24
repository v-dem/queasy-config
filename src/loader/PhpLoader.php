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
     * Load and return an array containing configuration.
     *
     * @return array Loaded configuration
     */
    public function load()
    {
        $path = $this->path();

        try {
            ob_start();

            $data = include($path);

            ob_end_clean(); // Stop output buffering
        } catch (\Throwable $e) {
            ob_end_clean(); // Clean possible output (to avoid displaying config as a plain text when for example there's no PHP opening tag)

            throw ConfigException::fileIsCorrupted($path);
        }

        if (!is_array($data)) {
            throw ConfigException::fileIsCorrupted($path);
        }

        return $data;
    }
}

