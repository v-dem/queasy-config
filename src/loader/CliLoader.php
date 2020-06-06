<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\loader;

use Exception;
use SimpleXMLElement;

/**
 * CLI configuration loader class
 */
class CliLoader extends AbstractLoader
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
        global $argv;

        $args = $argv;
        array_shift($args);

        $result = array();
        foreach ($args as $arg) {
            $argParts = explode('=', $arg);

            $argName = array_shift($argParts);
            $argValue = array_shift($argParts);

            $result[$argName] = trim(trim($argValue, '"'));
        }

        return $result;
    }

    public function check()
    {
        if (php_sapi_name() !== 'cli') {
            throw new CorruptedException('cli');
        }

        return true;
    }
}

