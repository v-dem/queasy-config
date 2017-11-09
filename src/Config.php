<?php

namespace queasy\config;

class Config implements ConfigInterface
{

    const DEFAULT_PATH = 'queasy-config.php';

    private $data;

    public function __construct($data = null)
    {
        if (is_null($data)) {
            if (defined('QUEASY_CONFIG_PATH')) {
                $data = QUEASY_CONFIG_PATH;
            } else {
                $data = self::DEFAULT_PATH;
            }
        } else if (!is_string($data)
                && !is_array($data)) {
            throw new ConfigException('Invalid argument type.');
        }

        $this->data = $data;
    }

    protected function createLoader($path)
    {
        return new Loader($path);
    }

    protected function data($key = null)
    {
        // Lazy loading
        if (is_string($this->data)) {
            $loader = $this->createLoader($this->data);

            $this->data = $loader();
        }

        if (is_null($key)) {
            return $this->data;
        } else {
            return $this->data[$key];
        }
    }

    public function __get($key)
    {
        return $this->data($key);
    }

    public function get($key, $default = null)
    {
        $data = $this->data();

        return isset($data[$key])? $this->$key: $default;
    }

    public function need($key)
    {
        $data = $this->data();

        if (!isset($data[$key])) {
            throw new ConfigException(sprintf('Mandatory config key "%s" is missing.', $key));
        }

        return $this->$key;
    }

    public function rewind()
    {
        reset($this->data());
    }

    public function current()
    {
        return $this->checkForLoader(current($this->data()));
    }

    public function next()
    {
        return $this->checkForLoader(next($this->data()));
    }

    public function key()
    {
        return key($this->data());
    }

    public function valid()
    {
        $key = key($this->data());

        return ($key !== null) && ($key !== false);
    }

    public function count()
    {
        return count($this->data());
    }

    public function offsetExists($key)
    {
        return isset($this->data()[$key]);
    }

    public function offsetGet($key)
    {
        return $this->offsetExists($key)
            ? $this->checkItem($this->$key)
            : null;
    }

    public function offsetSet($key, $value)
    {
        throw new ConfigException('Cannot change config at runtime.');
    }

    public function offsetUnset($key)
    {
        throw new ConfigException('Cannot change config at runtime.');
    }

    public function toArray()
    {
        return $this->data();
    }

    private function checkItem($item)
    {
        if (is_object($item)
                && ('queasy\config\Config' === get_class($item))) {
            return $item;
        } else if (is_array($item)) {
            return new Config($item);
        }

        return $item;
    }

}

