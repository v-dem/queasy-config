<?php

/*
 * Queasy PHP Framework - Configuration - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests\loader;

use InvalidArgumentException;

use PHPUnit\Framework\TestCase;

use queasy\config\loader\NotFoundException;
use queasy\config\loader\NotImplementedException;
use queasy\config\loader\AlreadyRegisteredException;
use queasy\config\loader\LoaderFactory;
// use queasy\config\tests\loader\CustomLoader;
// use queasy\config\tests\loader\WrongCustomLoader;

class LoaderFactoryTest extends TestCase
{
    public function testCheckRegisteredLoaders()
    {
        $this->assertEquals('queasy\config\loader\IniLoader', LoaderFactory::registered('test.ini'));
        $this->assertEquals('queasy\config\loader\JsonLoader', LoaderFactory::registered('test.json'));
        $this->assertEquals('queasy\config\loader\PhpLoader', LoaderFactory::registered('test.php'));
        $this->assertEquals('queasy\config\loader\XmlLoader', LoaderFactory::registered('test.xml'));
    }

    public function testNotRegisteredLoader()
    {
        $this->assertFalse(LoaderFactory::registered('test.abcd'));
    }

    public function testCreateNotRegisteredLoader()
    {
        $this->expectException(NotFoundException::class);

        LoaderFactory::create('test.abcd');
    }

    public function testRegisterCustomLoader()
    {
        require_once('CustomLoader.php');

        LoaderFactory::register('/\.abcd$/i', 'queasy\config\tests\loader\CustomLoader');

        $this->assertEquals('queasy\config\tests\loader\CustomLoader', LoaderFactory::registered('test.abcd'));
    }

    public function testRegisterWrongCustomLoader()
    {
        require_once('WrongCustomLoader.php');

        $this->expectException(NotImplementedException::class);

        LoaderFactory::register('/\.abcde$/i', 'queasy\config\tests\loader\WrongCustomLoader');
    }

    public function testRegisterCustomLoaderTwice()
    {
        require_once('CustomLoader.php');

        LoaderFactory::register('/\.abcd2$/i', 'queasy\config\tests\loader\CustomLoader');

        $this->expectException(AlreadyRegisteredException::class);

        LoaderFactory::register('/\.abcd2$/i', 'queasy\config\tests\loader\CustomLoader');
    }

    public function testRegisterCustomLoaderTwiceIgnore()
    {
        require_once('CustomLoader.php');

        LoaderFactory::register('/\.abcd3$/i', 'queasy\config\tests\loader\CustomLoader');

        try {
            LoaderFactory::register('/\.abcd3$/i', 'queasy\config\tests\loader\CustomLoader', true);
        } catch (AlreadyRegisteredException $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}

