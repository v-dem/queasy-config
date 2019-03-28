<?php

/*
 * Queasy PHP Framework - Configuration - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests;

use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;

use queasy\config\loader\PhpLoader;
use queasy\config\ConfigException;

class PhpLoaderTest extends TestCase
{
    public function testCorrect()
    {
        $loader = new PhpLoader(__DIR__ . '/../resources/correct.php');
        $result = $loader();

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
        $this->assertCount(4, $result);

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
        $loader = new PhpLoader(__DIR__ . '/../resources/correct-empty.php');
        $result = $loader();

        $this->assertTrue(is_array($result));
        $this->assertCount(0, $result);
    }

    public function testMissingFile()
    {
        $loader = new PhpLoader(__DIR__ . '/../resources/missing-file.php');

        $this->expectException(ConfigException::class);

        $result = $loader();
    }

    public function testIncorrectNotEmpty()
    {
        $loader = new PhpLoader(__DIR__ . '/../resources/incorrect-not-empty.php');

        $this->expectException(ConfigException::class);

        $result = $loader();
    }

    public function testIncorrectNotEmpty2()
    {
        $loader = new PhpLoader(__DIR__ . '/../resources/incorrect-not-empty2.php');

        $this->expectException(ConfigException::class);

        $result = $loader();
    }

    public function testWrongReturnInt()
    {
        $loader = new PhpLoader(__DIR__ . '/../resources/wrong-return-int.php');

        $this->expectException(ConfigException::class);

        $result = $loader();
    }

    public function testWrongReturnString()
    {
        $loader = new PhpLoader(__DIR__ . '/../resources/wrong-return-string.php');

        $this->expectException(ConfigException::class);

        $result = $loader();
    }

    public function testWrongReturnNothing()
    {
        $loader = new PhpLoader(__DIR__ . '/../resources/wrong-return-nothing.php');

        $this->expectException(ConfigException::class);

        $result = $loader();
    }

    public function testNotAStringAsPath()
    {
        $loader = new PhpLoader(array(123));

        $this->expectException(Error::class);

        $result = $loader();
    }
}

