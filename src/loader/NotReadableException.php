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
 * Configuration loader exception class - Config file is not accessible/readable
 */
class FileNotReadableException extends ConfigLoaderException
{
    /**
     * Constructor.
     *
     * @param string $path Path to config file
     */
    public function __construct($path)
    {
        parent::__construct(sprintf('Config file "%s" cannot be read.', $path));
    }
}

