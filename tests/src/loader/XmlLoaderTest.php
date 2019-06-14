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
use queasy\config\loader\XmlLoader;
use queasy\config\loader\NotFoundException;
use queasy\config\loader\CorruptedException;

class XmlLoaderTest extends TestCase
{
    public function testCorrect()
    {
        $loader = new XmlLoader(__DIR__ . '/../../resources/correct.xml');
        $result = $loader();
        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('section1', $result);
        $this->assertTrue(is_array($result['section1']));
        $this->assertGreaterThan(0, count($result['section1']));
        $this->assertCount(3, $result['section1']);
        $this->assertArrayHasKey('key11', $result['section1']);
        $this->assertEquals('value11', $result['section1']['key11']);
        $this->assertArrayHasKey('key12', $result['section1']);
        $this->assertEquals('value12', $result['section1']['key12']);
        $this->assertArrayHasKey('section2', $result);
        $this->assertTrue(is_array($result['section2']));
        $this->assertGreaterThan(0, count($result['section2']));
        $this->assertCount(3, $result['section2']);
        $this->assertArrayHasKey('key21', $result['section2']);
        $this->assertEquals('value21', $result['section2']['key21']);
        $this->assertArrayHasKey('key22', $result['section2']);
        $this->assertEquals('value22', $result['section2']['key22']);
    }

    public function testCorrectEmpty()
    {
        $loader = new XmlLoader(__DIR__ . '/../../resources/correct-empty.xml');
        $result = $loader();
        $this->assertTrue(is_array($result));
        $this->assertCount(0, $result);
        $this->assertEmpty($result);
    }

    public function testMissingFile()
    {
        $this->expectException(NotFoundException::class);
        return (new XmlLoader(__DIR__ . '/../../resources/missing-file.xml'))();

    }

    public function testIncorrectNotEmpty()
    {
        $this->expectException(CorruptedException::class);
        return (new XmlLoader(__DIR__ . '/../../resources/incorrect-not-empty.xml'))();
    }
}
