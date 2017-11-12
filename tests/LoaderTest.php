<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\tests;

// use PHPUnit\Framework\Error;
use PHPUnit\Framework\TestCase;

use queasy\config\Loader;
use queasy\config\ConfigException;

class LoaderTest extends TestCase
{

    public function testCorrectEmpty()
    {
        $loader = new Loader('tests/resources/correct-empty.php');
        $result = $loader->load();

        $this->assertTrue(is_array($result));
    }

    public function testMissingFile()
    {
        $loader = new Loader('tests/resources/missing-file.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader->load();
    }

    public function testWrongReturnInt()
    {
        $loader = new Loader('tests/resources/wrong-return-int.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader->load();
    }

    public function testWrongReturnString()
    {
        $loader = new Loader('tests/resources/wrong-return-string.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader->load();
    }

    public function testWrongReturnNothing()
    {
        $loader = new Loader('tests/resources/wrong-return-nothing.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader->load();
    }

    public function testNoConstructorArgs()
    {
        $this->setExpectedException(\PHPUnit_Framework_Error::class);

        $loader = new Loader();
    }

    public function testNotAStringAsPath()
    {
        $loader = new Loader(array(123));

        $this->setExpectedException(\PHPUnit_Framework_Error::class);

        $result = $loader->load();
    }

}

