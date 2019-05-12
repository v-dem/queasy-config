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
 * Configuration loader exception class - LoaderInterface not implemented
 */
class NotImplementedException extends ConfigLoaderException
{
    /**
     * Constructor.
     *
     * @param string $className Loader class name
     */
    public function __construct($className)
    {
        parent::__construct(sprintf('Custom config loader "%s" does not implement LoaderInterface.', $className));
    }
}

