<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests;

use queasy\config\loader\LoaderInterface;

class CustomLoader implements LoaderInterface
{
    public function load()
    {
        // Do nothing
    }

    public function __invoke()
    {
        // Do nothing
    }
}

