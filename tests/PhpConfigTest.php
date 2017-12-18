<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests;

use InvalidArgumentException;

use PHPUnit\Framework\TestCase;

use queasy\config\Config;
use queasy\config\ConfigException;

class PhpConfigTest extends TestCase
{
    public function testCorrect()
    {
        $config = new Config(__DIR__ . '/resources/correct.php');

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
        $config = new Config(__DIR__ . '/resources/correct-empty.php');

        $this->assertCount(0, $config);
    }

    public function testMissingFile()
    {
        $config = new Config(__DIR__ . '/resources/missing-file.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testIncorrectNotEmpty()
    {
        $config = new Config(__DIR__ . '/resources/incorrect-not-empty.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testWrongReturnInt()
    {
        $config = new Config(__DIR__ . '/resources/wrong-return-int.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testWrongReturnString()
    {
        $config = new Config(__DIR__ . '/resources/wrong-return-string.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testWrongReturnNothing()
    {
        $config = new Config(__DIR__ . '/resources/wrong-return-nothing.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testNotAStringOrArrayAsParameter()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Config(true);
    }
}

