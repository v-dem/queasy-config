<?php

namespace queasy\config;

class AbstractLoader implements LoaderInterface
{

    abstract public function load();

    public function __invoke()
    {
        return $this->load();
    }

}

