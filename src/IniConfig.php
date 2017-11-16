<?php
/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

use queasy\config\loader\IniLoader;

/**
 * INI configuration class
 */
class IniConfig extends Config
{

    const DEFAULT_PATH = 'queasy-config.ini';

    /**
     * Creates a config loader instance.
     *
     * @param string $path Path to config file
     *
     * @return IniLoader IniLoader instance
     */
    protected function createLoader($path)
    {
        return new IniLoader($path);
    }

}

