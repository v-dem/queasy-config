<?php
/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

use queasy\config\loader\JsonLoader;

/**
 * JSON configuration class
 */
class JsonConfig extends Config
{

    const DEFAULT_PATH = 'queasy-config.json';

    /**
     * Creates a config loader instance.
     *
     * @param string $path Path to config file
     *
     * @return JsonLoader JsonLoader instance
     */
    protected function createLoader($path)
    {
        return new JsonLoader($path);
    }

}

