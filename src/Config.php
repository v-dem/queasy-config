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
            throw new \InvalidArgumentException('Invalid argument type. Only NULL, String or Array allowed.');
        }

        $this->data = $data;
    }

    public function __get($key)
    {
        return $this->item($key);
    }

    public function get($key, $default = null)
    {
        return $this->offsetExists($key)? $this->$key: $default;
    }

    public function need($key)
    {
        if (!$this->offsetExists($key)) {
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
        return $this->item(current($this->data()));
    }

    public function next()
    {
        return $this->item(next($this->data()));
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
        $data = $this->data();

        return isset($data[$key]);
    }

    public function offsetGet($key)
    {
        return $this->offsetExists($key)
            ? $this->item($this->$key)
            : null;
    }

    public function offsetSet($key, $value)
    {
        throw new \BadMethodCallException('Not implemented. Config is read-only.');
    }

    public function offsetUnset($key)
    {
        throw new \BadMethodCallException('Not implemented. Config is read-only.');
    }

    public function toArray($arr = null)
    {
        $result = array();
        foreach ($this->data() as $key => $item) {
            $item = $this->item($item);
            if (is_object($item)
                    && (get_class($this) === get_class($item))) {
                $result[$key] = $item->toArray();
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }

    protected function createLoader($path)
    {
        return new Loader($path);
    }

    protected function &data()
    {
        if (!is_array($this->data)) {
            $loader = $this->createLoader($this->data);

            $this->data = $loader();
        }

        return $this->data;
    }

    protected function item($item)
    {
        if (is_object($item)
                && (get_class($this) === get_class($item))) {
            return $item;
        } else if (is_array($item)) {
            return new Config($item);
        }

        return $item;
    }

}

