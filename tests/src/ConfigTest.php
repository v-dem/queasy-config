<?php

/*
 * Queasy PHP Framework - Configuration - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests;

use PHPUnit\Framework\TestCase;

use queasy\config\Config;
use queasy\config\loader\ConfigLoaderException;
use queasy\config\InvalidPathException;
use queasy\config\MissingOptionException;

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

    public function testCorrectCompoundPhp()
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

    public function testCorrectCompoundIni()
    {
        $config = new Config(__DIR__ . '/../resources/correct-compound.ini');

        $this->assertCount(2, $config);
        $this->assertArrayHasKey('include-section', $config);
        $this->assertCount(1, $config['include-section']);
        $this->assertArrayHasKey('section', $config['include-section']);
        $this->assertCount(1, $config['include-section']['section']);
        $this->assertArrayHasKey('key', $config['include-section']['section']);
        $this->assertEquals('value', $config['include-section']['section']['key']);
    }

    public function testInvoke()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('value11', $config('section1')('key11'));
    }

    public function testInvokeDefault()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('default', $config('section1')('key13', 'default'));
    }

    public function testInvokeDefault2()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('default', $config('section3', array())('key13', 'default'));
    }

    public function testIsset()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertTrue(isset($config->key));
    }

    public function testIssetArray()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertTrue(isset($config['key']));
    }

    public function testIssetNotExisting()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertFalse(isset($config->unknown));
    }

    public function testIssetNotExistingArray()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertFalse(isset($config['unknown']));
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

    public function testGetDefaultForMissingSection()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertEquals('default', $config->get('section3', [])->get('key31', 'default'));
    }

    public function testGetForMissingSection()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertNull($config['section3']['key31']);
    }

    public function testGetForMissingRequiredSection()
    {
        $this->expectException(MissingOptionException::class);

        $config = new Config(__DIR__ . '/../resources/correct.php');

        return $this->assertNull($config->need('section3')['key31']);
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

        $this->assertEquals('value', $config->need('key'));
    }

    public function testRequiredMissing()
    {
        $this->expectException(MissingOptionException::class);

        $config = new Config(__DIR__ . '/../resources/correct.php');

        return $config->need('unknown');
    }

    public function testRequiredNullExisting()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $this->assertArrayHasKey('nullkey', $config);
        $this->assertNull($config->need('nullkey'));
    }

    public function testRegex()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $options = $config->regex('/^sec/');

        $this->assertCount(2, $options);

        $options = $config->regex('/key/');

        $this->assertCount(2, $options);
        $this->assertArrayHasKey('key', $options);
        $this->assertArrayHasKey('nullkey', $options);
    }

    public function testForeachKeys()
    {
        $config = new Config(__DIR__ . '/../resources/correct.php');

        $keys = array();
        foreach ($config as $key => $value) {
            $keys[] = $key;
        }

        $this->assertCount(4, $keys);
        $this->assertEquals(array('section1', 'section2', 'key', 'nullkey'), $keys);
    }

    public function testMissingFile()
    {
        $this->expectException(ConfigLoaderException::class);

        return (new Config(__DIR__ . '/../resources/missing-file.php'))['a'];
    }

    public function testIncorrectNotEmpty()
    {
        $this->expectException(ConfigLoaderException::class);

        return (new Config(__DIR__ . '/../resources/incorrect-not-empty.php'))['a'];
    }

    public function testWrongReturnInt()
    {
        $this->expectException(ConfigLoaderException::class);

        return (new Config(__DIR__ . '/../resources/incorrect-return-int.php'))['a'];
    }

    public function testWrongReturnString()
    {
        $this->expectException(ConfigLoaderException::class);

        return (new Config(__DIR__ . '/../resources/incorrect-return-string.php'))['a'];

    }

    public function testWrongReturnNothing()
    {
        $this->expectException(ConfigLoaderException::class);

        return (new Config(__DIR__ . '/../resources/incorrect-return-nothing.php'))['a'];
    }

    public function testNotAStringOrArrayAsParameter()
    {
        $this->expectException(InvalidPathException::class);

        return new Config(true);
    }
}

