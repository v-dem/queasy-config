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
 * Configuration loader exception class - Loader already registered
 */
class AlreadyRegisteredException extends ConfigLoaderException
{
    /**
     * Constructor.
     *
     * @param string $pattern Regex pattern of registered loader
     */
    public function __construct($pattern)
    {
        parent::__construct(sprintf('Custom loader for pattern "%s" already registered.', $pattern));
    }
}

