<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\loader;

use Exception;
use SimpleXMLElement;

use queasy\config\ConfigException;

/**
 * XML configuration loader class
 */
class XmlLoader extends FileSystemLoader
{
    /**
     * Load and return an array containing configuration.
     *
     * @return array Loaded configuration
     */
    public function load()
    {
        $path = $this->path();

        try {
            $xml = new SimpleXMLElement(file_get_contents($path));

            return $this->buildFromXml($xml);
        } catch (Exception $e) {
            throw ConfigException::fileIsCorrupted($this->path());
        }
    }

    private function buildFromXml(SimpleXMLElement $el)
    {
        $result = array();

        foreach ($el->attributes() as $attr => $value) {
            $result[$attr] = trim($value);
        }

        foreach ($el->children() as $name => $value) {
            if (!isset($result[$name])) {
                $result[$name] = array();
            }

            $childConfig = $this->buildFromXml($value);

            $result[$name] = array_merge($result[$name], $childConfig);
            $result[$name][] = $childConfig;
        }

        $text = trim($el->__toString());
        if (!empty($text)) {
            $result[''] = $text;
        }

        return $result;
    }
}

