<?php

use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use Slim\Routing\RouteCollectorProxy;

// za id koristiti {id:[0-9]+}

// pristup za sve
$app->get('/', App\Controllers\PocetnaController::class . ':getPocetna')->setName('pocetna');

// samo za Ne prijavljene
$app->get('/prijava', App\Controllers\AuthController::class . ':getPrijava')->setName('prijava')
    ->add(new GuestMiddleware($container));
$app->post('/prijava', App\Controllers\AuthController::class . ':postPrijava')->setName('prijava.post')
    ->add(new GuestMiddleware($container));

// samo za prijavljene
$app->group('', function (RouteCollectorProxy $group) {

    $group->get('/odjava', App\Controllers\AuthController::class . ':getOdjava')->setName('odjava');
})->add(new AuthMiddleware($container));
