<?php

namespace queasy\config;

interface ConfigInterface extends \Iterator, \ArrayAccess, \Countable
{

    public function get($key, $default = null);

    public function need($key);

    public function toArray();

}

