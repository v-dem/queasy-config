<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

use BadMethodCallException as StandardBadMethodCallException;

/**
 * BadMethodCallException
 */
class BadMethodCallException extends StandardBadMethodCallException
{
    /**
     * Create exception for not implemented method call.
     *
     * @return BadMethodCallException Exception instance
     */
    public static function notImplemented($method)
    {
        return new BadMethodCallException(sprintf('Method "%s" is not implemented. Config is read-only', $method));
    }
}

