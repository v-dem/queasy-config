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
 * Configuration exception class - Missing required config option
 */
class MissingOptionException extends ConfigException
{
    /**
     * Constructor.
     *
     * @param string $name Config option name
     */
    public function __construct($name)
    {
        parent::__construct(sprintf('Missing config option "%s".', $name));
    }
}

