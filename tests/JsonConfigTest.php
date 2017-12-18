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

use queasy\config\Config;
use queasy\config\ConfigException;

class JsonConfigTest extends TestCase
{
    public function testCorrect()
    {
        $config = new Config(__DIR__ . '/resources/correct.json');

        $this->assertGreaterThan(0, count($config));
        $this->assertCount(2, $config);

        $this->assertArrayHasKey('section1', $config);
        $this->assertGreaterThan(0, count($config['section1']));
        $this->assertCount(2, $config['section1']);
        $this->assertArrayHasKey('key11', $config['section1']);
        $this->assertEquals('value11', $config['section1']['key11']);
        $this->assertArrayHasKey('key12', $config['section1']);
        $this->assertEquals('value12', $config['section1']['key12']);

        $this->assertArrayHasKey('section2', $config);
        $this->assertGreaterThan(0, count($config['section2']));
        $this->assertCount(2, $config['section2']);
        $this->assertArrayHasKey('key21', $config['section2']);
        $this->assertEquals('value21', $config['section2']['key21']);
        $this->assertArrayHasKey('key22', $config['section2']);
        $this->assertEquals('value22', $config['section2']['key22']);
    }

    public function testCorrectEmpty()
    {
        $config = new Config(__DIR__ . '/resources/correct-empty.json');

        $this->assertCount(0, $config);
        $this->assertEmpty($config);
    }

    public function testMissingFile()
    {
        $config = new Config(__DIR__ . '/resources/missing-file.json');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testIncorrectNotEmpty()
    {
        $config = new Config(__DIR__ . '/resources/incorrect-not-empty.json');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }
}

