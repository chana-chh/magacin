<?php

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'renderer' => [
            'template_path' => DIR . 'App' . DS . 'views',
            'cache_path' => false,
        ],
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=magacin;charset=utf8mb4',
            'username' => 'root',
            'password' => '',
            'options' => [
                \PDO::ATTR_PERSISTENT => true,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            ],
        ],
    ],
];
