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
 * Configuration exception class - Invalid config path type
 */
class InvalidPathException extends ConfigException
{
    /**
     * Constructor.
     *
     * @param string $type Path type
     */
    public function __construct($type)
    {
        parent::__construct(sprintf('Invalid argument type "%s". Only null, string or array allowed.', $type));
    }
}

