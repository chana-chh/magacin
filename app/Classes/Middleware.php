<?php

namespace App\Classes;

use Psr\Container\ContainerInterface;

class Middleware
{
    public function __construct(protected ContainerInterface $container) {}
}
