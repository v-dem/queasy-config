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
 * Configuration loader abstraction
 */
abstract class AbstractLoader implements LoaderInterface
{
    /**
     * Class invokation method representing load()
     *
     * @return array Loaded configuration
     */
    public function __invoke()
    {
        if ($this->check()) {
            return $this->load();
        }
    }

    /**
     * Load and return an array containing configuration
     *
     * @return array Loaded configuration
     */
    abstract public function load();

    /**
     * Check whether configuration is available and can be loaded
     *
     * @return boolean True or false or throw exception
     */
    abstract public function check();
}

