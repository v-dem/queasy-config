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

use queasy\config\PhpLoader;
use queasy\config\ConfigException;

class PhpLoaderTest extends TestCase
{

    public function testCorrectEmpty()
    {
        $loader = new PhpLoader('tests/resources/correct-empty.php');
        $result = $loader();

        $this->assertTrue(is_array($result));
    }

    public function testMissingFile()
    {
        $loader = new PhpLoader('tests/resources/missing-file.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader();
    }

    public function testWrongReturnInt()
    {
        $loader = new PhpLoader('tests/resources/wrong-return-int.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader();
    }

    public function testWrongReturnString()
    {
        $loader = new PhpLoader('tests/resources/wrong-return-string.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader();
    }

    public function testWrongReturnNothing()
    {
        $loader = new PhpLoader('tests/resources/wrong-return-nothing.php');

        $this->setExpectedException(ConfigException::class);

        $result = $loader();
    }

    public function testNoConstructorArgs()
    {
        $this->setExpectedException(\PHPUnit_Framework_Error::class);

        $loader = new PhpLoader();
    }

    public function testNotAStringAsPath()
    {
        $loader = new PhpLoader(array(123));

        $this->setExpectedException(\PHPUnit_Framework_Error::class);

        $result = $loader();
    }

}

