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
 * Configuration loader abstraction
 */
abstract class AbstractLoader implements LoaderInterface
{

    /**
     * Loads and returns an array containing configuration
     *
     * @return array Loaded configuration
     */
    abstract public function load();

    /**
     * Class invokation method representing load()
     *
     * @return array Loaded configuration
     */
    public function __invoke()
    {
        return $this->load();
    }

}

