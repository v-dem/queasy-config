<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests;

use PHPUnit\Framework\TestCase;

use queasy\config\loader\LoaderFactory;

class LoaderFactoryTest extends TestCase
{
    public function testCheckRegisteredLoaders()
    {
        $this->assertEquals('queasy\config\loader\IniLoader', LoaderFactory::registered('test.ini'));
    }
}

