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
 * Configuration loader interface
 */
interface LoaderInterface
{

    /**
     * Loads and returns an array containing configuration.
     *
     * @return array Loaded configuration
     */
    function load();

    // function default();

    /**
     * Class invokation method representing load().
     *
     * @return array Loaded configuration
     */
    function __invoke();

}
