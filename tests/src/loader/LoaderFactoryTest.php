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
use queasy\config\loader\NotImplementedException;
use queasy\config\loader\AlreadyRegisteredException;
use queasy\config\loader\LoaderFactory;

// use queasy\config\tests\loader\CustomLoader;
// use queasy\config\tests\loader\WrongCustomLoader;

class LoaderFactoryTest extends TestCase
{
    public function testCheckRegisteredLoaders()
    {
        $this->assertEquals(\queasy\config\loader\IniLoader::class, LoaderFactory::registered('test.ini'));
        $this->assertEquals(\queasy\config\loader\JsonLoader::class, LoaderFactory::registered('test.json'));
        $this->assertEquals(\queasy\config\loader\PhpLoader::class, LoaderFactory::registered('test.php'));
        $this->assertEquals(\queasy\config\loader\XmlLoader::class, LoaderFactory::registered('test.xml'));
    }

    public function testCreateNotRegisteredLoader()
    {
        $this->expectException(NotFoundException::class);

        return LoaderFactory::create('test.abcd');
    }

    public function testNotRegisteredLoader()
    {
        $this->assertFalse(LoaderFactory::registered('test.abcd'));
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
