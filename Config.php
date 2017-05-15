<?php

namespace queasy\config;

class Config implements \Iterator, \ArrayAccess, \Countable
{

    private $data;

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function __get($key)
    {
        return $this[$key];
    }

    public function get($key, $default = null)
    {
        return isset($this[$key])? $this[$key]: $default;
    }

    public function need($key)
    {
        if (!isset($this[$key])) {
            throw new ConfigException(sprintf('Mandatory config key "%s" is missing.', $key));
        }

        return $this->$key;
    }

    public function rewind()
    {
        reset($this->data);
    }

    public function current()
    {
        return $this->checkForLoader(current($this->data));
    }

    public function next()
    {
        return $this->checkForLoader(next($this->data));
    }

    public function key()
    {
        return key($this->data);
    }

    public function valid()
    {
        $key = key($this->data);

        return ($key !== null) && ($key !== false);
    }

    public function count()
    {
        return count($this->data);
    }

    public function offsetExists($key)
    {
        return isset($this->data[$key]);
    }

    public function offsetGet($key)
    {
        return $this->offsetExists($key)
            ? $this->checkForLoader($this->data[$key])
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

    private function checkForLoader($item)
    {
        if (is_object($item)
                && ('queasy\\config\\Loader' === get_class($item))) {
            $item = $item();
        } else if (is_array($item)) {
            $item = new Config($item);
        }

        return $item;
    }

    public function toArray()
    {
        return $this->data;
    }

}

