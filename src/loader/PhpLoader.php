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
 * Standard (PHP-based) configuration loader class
 */
class PhpLoader extends FileSystemLoader
{
    /**
     * Load and return an array containing configuration.
     *
     * @return array Loaded configuration
     *
     * @throws ConfigLoaderException When file is corrupted
     */
    public function load()
    {
        $path = $this->path();

        if (interface_exists('Throwable')) {
            try {
                ob_start();

                $data = include($path);

                ob_end_clean(); // Stop output buffering
            } catch (\Throwable $e) {
                ob_end_clean(); // Clean possible output (to avoid displaying config as a plain text when for example there's no PHP opening tag)

                throw new CorruptedException($path);
            }
        } else {
            $data = include($path);
        }

        if (!is_array($data)) {
            throw new CorruptedException($path);
        }

        return $data;
    }
}

