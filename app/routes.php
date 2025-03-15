<?php

// za id koristiti {id:\d+}
$app->get('/', App\Controllers\PocetnaController::class . ':getPocetna')->setName('pocetna');
$app->get('/prijava', App\Controllers\AuthController::class . ':getPrijava')->setName('prijava');
$app->post('/prijava', App\Controllers\AuthController::class . ':postPrijava')->setName('prijava.post');
$app->get('/odjava', App\Controllers\AuthController::class . ':getOdjava')->setName('odjava');
