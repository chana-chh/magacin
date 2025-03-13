<?php

use App\Classes\Config;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'ini.php';
Config::instance($container);
$app->run();
