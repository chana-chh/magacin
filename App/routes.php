<?php

use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

$app->get('/', '\App\Controllers\HomeController:getHome')->setName('pocetna');

$app->group('', function () {
    $this->get('/prijava', '\App\Controllers\AuthController:getPrijava')->setName('prijava');
    $this->post('/prijava', '\App\Controllers\AuthController:postPrijava');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    $this->get('/odjava', '\App\Controllers\AuthController:getOdjava')->setName('odjava');
    // Promena lozinke
    // $this->get('/promena', '\App\Controllers\AuthController:getPromena')->setName('promena');
    // $this->post('/promena', '\App\Controllers\AuthController:postPromena')->setName('promena');
})->add(new AuthMiddleware($container));
