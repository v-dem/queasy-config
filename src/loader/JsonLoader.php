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
 * JSON configuration loader class
 */
class JsonLoader extends FileSystemLoader
{
    /**
     * Loads and returns an array containing configuration.
     *
     * @return array Loaded configuration
     */
    public function load()
    {
        $path = $this->path();

        $data = json_decode(file_get_contents($path), true);
        if (!is_array($data)) {
            throw new ConfigException(sprintf('Config file "%s" is corrupted.', $path));
        }

        return $data;
    }
}

