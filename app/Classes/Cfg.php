<?php

namespace App\Classes;

use Exception;

class Cfg
{
    private static $instance = null;
    private static $container;

    public static function instance($container)
    {
        if (!isset(static::$instance)) {
            static::$instance = new static($container);
        }
        return static::$instance;
    }

    private function __construct($container)
    {
        static::$container = $container;
    }

    private function __clone() {}

    public function __sleep() {}

    public function __wakeup() {}

    public static function get(string $key, mixed $default = null)
    {
        if (!is_string($key) || empty($key)) {
            throw new Exception("Naziv konfiguracije nije ispravan");
        }
        $data = static::$container->get($key);
        return $data === null ? $default : $data;
    }
}
