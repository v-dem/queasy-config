<?php

namespace queasy\config;

interface LoaderInterface
{

    public function load();

    public function __invoke();

}

