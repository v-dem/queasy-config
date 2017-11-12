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
 * INI configuration class
 */
class IniConfig extends Config
{

    /**
     * Creates a config loader instance.
     *
     * @param string $path Path to config file
     *
     * @return IniLoader IniLoader instance
     *
     * @throws ConfigException When configuration load attempt fails, in case of missing or corrupted (doesn't returning an array) file
     */
    protected function createLoader($path)
    {
        return new IniLoader($path);
    }

}

