<?php

/*
 * Queasy PHP Framework - Configuration - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests\loader;

use queasy\config\loader\LoaderInterface;

/**
 * @codeCoverageIgnore
 */
class CustomLoader implements LoaderInterface
{
    public function load()
    {
    }

    public function check()
    {
    }

    public function __invoke()
    {
    }
}

