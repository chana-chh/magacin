<?php

$config = [
    'settings' => [
        'cyrillic' => true, // da li je aplikacija cirilicna
        'pagination' => [
            // Podesavanja za stranicenje
            'per_page' => 10,
            'page_span' => 3,
            'css' => [ // TODO prepraviti za bootstrap 5.3
                'buttons_container' => 'uk-pagination',
                'button_active' => 'uk-active',
                'button_disabled' => 'uk-disabled',
                'goto' => 'uk-select uk-form-width-xsmall uk-form-small uk-text-primary',
            ],
        ],
        'displayErrorDetails' => true, // da li ovo radi u Slim4
        'renderer' => [
            'template_path' => DIR . 'app' . DS . 'views',
            'cache_path' => false,
        ],
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=magacin;charset=utf8mb4',
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
