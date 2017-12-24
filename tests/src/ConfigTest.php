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

class ConfigTest extends TestCase
{
    public function testCorrect()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertGreaterThan(0, count($config));
        $this->assertCount(4, $config);

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
        $config = new Config(__DIR__ . '/../resources/correct-empty.php');

        $this->assertCount(0, $config);
    }

    public function testCorrectCompound()
    {
        $config = new Config(__DIR__ . '/../resources/correct-compound.php');

        $this->assertCount(2, $config);
        $this->assertArrayHasKey('include-section', $config);
        $this->assertCount(1, $config['include-section']);
        $this->assertArrayHasKey('section', $config['include-section']);
        $this->assertCount(1, $config['include-section']['section']);
        $this->assertArrayHasKey('key', $config['include-section']['section']);
        $this->assertEquals('value', $config['include-section']['section']['key']);
    }

    public function testGet()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('value', $config->get('key'));
    }

    public function testGetAsField()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('value', $config->key);
    }

    public function testGetMissing()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertNull($config->get('unknown'));
    }

    public function testGetMissingAsField()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertNull($config->unknown);
    }

    public function testGetDefault()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('default', $config->get('unknown', 'default'));
    }

    public function testGetDefaultForExistingKey()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('value', $config->get('key', 'default'));
    }

    public function testGetForMissingSection()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->setExpectedException(ConfigException::class);

        $this->assertNull($config['section3']['key31']);
    }

    public function testCompoundGetInherited()
    {
        $config = new Config(__DIR__ . '/../resources/correct-compound.php');

        $this->assertEquals('parent-value', $config['include-section']['section']['parent-key']);
    }

    public function testCompoundGetInheritedWithDefault()
    {
        $config = new Config(__DIR__ . '/../resources/correct-compound.php');

        $this->assertEquals('parent-value', $config['include-section']['section']->get('parent-key', 'wrong-value'));
    }

    public function testRequired()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('value', $config['key']);
    }

    public function testRequiredMissing()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->setExpectedException(ConfigException::class);

        $value = $config['unknown'];
    }

    public function testRequiredNullExisting()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertArrayHasKey('nullkey', $config);
        $this->assertNull($config['nullkey']);
    }

    public function testMissingFile()
    {
        $config = new Config(__DIR__ . '/../resources/missing-file.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testIncorrectNotEmpty()
    {
        $config = new Config(__DIR__ . '/../resources/incorrect-not-empty.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testWrongReturnInt()
    {
        $config = new Config(__DIR__ . '/../resources/incorrect-return-int.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testWrongReturnString()
    {
        $config = new Config(__DIR__ . '/../resources/incorrect-return-string.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testWrongReturnNothing()
    {
        $config = new Config(__DIR__ . '/../resources/incorrect-return-nothing.php');

        $this->setExpectedException(ConfigException::class);

        $test = $config['a'];
    }

    public function testNotAStringOrArrayAsParameter()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Config(true);
    }
}

