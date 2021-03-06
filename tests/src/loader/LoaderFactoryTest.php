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

use queasy\config\loader\NotFoundException;
use queasy\config\loader\LoaderNotFoundException;
use queasy\config\loader\NotImplementedException;
use queasy\config\loader\AlreadyRegisteredException;
use queasy\config\loader\LoaderFactory;
use queasy\config\loader\IniLoader;
use queasy\config\loader\JsonLoader;
use queasy\config\loader\PhpLoader;
use queasy\config\loader\XmlLoader;

class LoaderFactoryTest extends TestCase
{
    public function testCheckRegisteredLoaders()
    {
        $this->assertEquals(IniLoader::class, LoaderFactory::registered('test.ini'));
        $this->assertEquals(JsonLoader::class, LoaderFactory::registered('test.json'));
        $this->assertEquals(PhpLoader::class, LoaderFactory::registered('test.php'));
        $this->assertEquals(XmlLoader::class, LoaderFactory::registered('test.xml'));
    }

    public function testCreateNotRegisteredLoader()
    {
        $this->expectException(LoaderNotFoundException::class);

        return LoaderFactory::create('test.abcdef');
    }

    public function testNotRegisteredLoader()
    {
        $this->assertFalse(LoaderFactory::registered('test.abcdef'));
    }

    public function testRegisterCustomLoader()
    {
        LoaderFactory::register('/\.abcd$/i', CustomLoader::class);

        $this->assertEquals(CustomLoader::class, LoaderFactory::registered('test.abcd'));
    }

    public function testRegisterCustomLoaderTwiceIgnore()
    {
        LoaderFactory::register('/\.abcd3$/i', CustomLoader::class);

        LoaderFactory::register('/\.abcd3$/i', CustomLoader::class, true);

        $this->assertTrue(true);
    }

    public function testRegisterWrongCustomLoader()
    {
        $this->expectException(NotImplementedException::class);

        return LoaderFactory::register('/\.abcde$/i', WrongCustomLoader::class);
    }

    public function testRegisterCustomLoaderTwice()
    {
        $this->expectException(AlreadyRegisteredException::class);

        LoaderFactory::register('/\.abcd2$/i', CustomLoader::class);

        return LoaderFactory::register('/\.abcd2$/i', CustomLoader::class);
    }
}

