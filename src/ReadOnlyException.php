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
class ReadOnlyException extends ConfigException
{
    /**
     * Constructor.
     *
     * @param string $method Method name
     */
    public function __construct($method)
    {
        parent::__construct(sprintf('Method "%s" is not implemented. Config is read-only', $method));
    }
}

