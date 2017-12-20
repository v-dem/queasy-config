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
 * INI file configuration loader class
 */
class IniLoader extends FileSystemLoader
{
    /**
     * Loads and returns an array containing configuration.
     *
     * @return array Loaded configuration
     */
    public function load()
    {
        $data = @parse_ini_file($this->path(), true);
        if (!is_array($data)) {
            throw ConfigException::fileIsCorrupted($this->path());
        }

        return $data;
    }
}

