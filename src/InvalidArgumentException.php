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
    /**
     * Create exception for not implemented loader interface case.
     *
     * @param string $className Loader class name
     * @param string $interfaceName Interface name required to be implemeted
     *
     * @return InvalidArgumentException Exception instance
     */
    public static function interfaceNotImplemented($className, $interfaceName)
    {
        return new InvalidArgumentException(sprintf('Custom config loader "%s" does not implement "%s".', $className, $interfaceName));
    }

    /**
     * Create exception for invalid config path parameter type.
     *
     * @param string $type Path parameter type
     *
     * @return InvalidArgumentException Exception instance
     */
    public static function invalidArgumentType($type)
    {
        return new InvalidArgumentException(sprintf('Invalid argument type "%s". Only null, string or array allowed.', $type));
    }
}

