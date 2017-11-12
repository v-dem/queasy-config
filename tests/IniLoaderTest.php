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

use queasy\config\IniLoader;
use queasy\config\ConfigException;

class IniLoaderTest extends TestCase
{

    public function testCorrectEmpty()
    {
        $loader = new IniLoader('tests/resources/correct-empty.ini');
        $result = $loader();

        $this->assertTrue(is_array($result));
    }

    public function testMissingFile()
    {
        $loader = new IniLoader('tests/resources/missing-file.ini');

        $this->setExpectedException(ConfigException::class);

        $result = $loader();
    }

    public function testIncorrectNotEmpty()
    {
        $loader = new IniLoader('tests/resources/incorrect-not-empty.ini');

        $this->setExpectedException(\PHPUnit_Framework_Error::class);

        $result = $loader();
    }

}

