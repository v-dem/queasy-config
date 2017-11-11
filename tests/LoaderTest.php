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
use queasy\config\Loader;

class LoaderTest extends TestCase
{

    public function testCorrectEmpty()
    {
        echo getcwd();
        $loader = new Loader('tests/data/correct-empty.php');
        $result = $loader->load();

        $this->assertTrue(is_array($result));
    }

}

