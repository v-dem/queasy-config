<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config;

use InvalidArgumentException as StandardInvalidArgumentException;

/**
 * InvalidArgumentException
 */
class InvalidArgumentException extends StandardInvalidArgumentException
{
    public static function notImplementsInterface($className, $interfaceName)
    {
        throw new InvalidArgumentException(sprintf('Custom config loader "%s" does not implement "%s".', $className, $interfaceName));
    }

    public static function invalidArgumentType()
    {
        throw new InvalidArgumentException('Invalid argument type. Only null, string or array allowed.');
    }
}

