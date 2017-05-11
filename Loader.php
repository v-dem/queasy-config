<?php

namespace queasy\config;

class Loader
{

    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function load()
    {
        if (!@file_exists($this->path)) {
            throw new ConfigException(sprintf('Config path "%s" not found.', $this->path));
        }

        $data = @include($this->path);
        if (!is_array($data)) {
            throw new ConfigException(sprintf('Config file "%s" is corrupted.', $this->path));
        }

        return new Config($data);
    }

    public function __invoke()
    {
        return $this->load();
    }

}

