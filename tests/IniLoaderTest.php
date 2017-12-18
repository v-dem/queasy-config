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

use queasy\config\loader\IniLoader;
use queasy\config\ConfigException;

class IniLoaderTest extends TestCase
{
    public function testCorrect()
    {
        $loader = new IniLoader(__DIR__ . '/resources/correct.ini');
        $result = $loader();

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
        $this->assertCount(2, $result);

        $this->assertArrayHasKey('section1', $result);
        $this->assertTrue(is_array($result['section1']));
        $this->assertGreaterThan(0, count($result['section1']));
        $this->assertCount(2, $result['section1']);
        $this->assertArrayHasKey('key11', $result['section1']);
        $this->assertEquals('value11', $result['section1']['key11']);
        $this->assertArrayHasKey('key12', $result['section1']);
        $this->assertEquals('value12', $result['section1']['key12']);

        $this->assertArrayHasKey('section2', $result);
        $this->assertTrue(is_array($result['section2']));
        $this->assertGreaterThan(0, count($result['section2']));
        $this->assertCount(2, $result['section2']);
        $this->assertArrayHasKey('key21', $result['section2']);
        $this->assertEquals('value21', $result['section2']['key21']);
        $this->assertArrayHasKey('key22', $result['section2']);
        $this->assertEquals('value22', $result['section2']['key22']);
    }

    public function testCorrectEmpty()
    {
        $loader = new IniLoader(__DIR__ . '/resources/correct-empty.ini');
        $result = $loader();

        $this->assertTrue(is_array($result));
        $this->assertCount(0, $result);
        $this->assertEmpty($result);
    }

    public function testMissingFile()
    {
        $loader = new IniLoader(__DIR__ . '/resources/missing-file.ini');

        $this->setExpectedException(ConfigException::class);

        $result = $loader();
    }

    public function testIncorrectNotEmpty()
    {
        $loader = new IniLoader(__DIR__ . '/resources/incorrect-not-empty.ini');

        $this->setExpectedException(ConfigException::class);

        $result = $loader();
    }
}

