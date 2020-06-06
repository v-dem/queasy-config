<?php

/*
 * Queasy PHP Framework - Configuration - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests\loader;

use PHPUnit\Framework\TestCase;
use queasy\config\loader\CliLoader;
use queasy\config\loader\NotFoundException;
use queasy\config\loader\CorruptedException;

class CliLoaderTest extends TestCase
{
    public function testCorrect()
    {
        global $argv;

        $argv = [
            '[command line, to be skipped]',
            'key1=value1',
            'key2=value2',
            'key3'
        ];

        $loader = new CliLoader();
        $result = $loader();

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
        $this->assertCount(3, $result);
        $this->assertArrayHasKey('key1', $result);
        $this->assertEquals('value1', $result['key1']);
        $this->assertArrayHasKey('key2', $result);
        $this->assertEquals('value2', $result['key2']);
        $this->assertArrayHasKey('key3', $result);
        $this->assertEquals('', $result['key3']);
    }
}

