<?php

use App\Classes\Cfg;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'ini.php';
Cfg::instance($container);
$app->run();
