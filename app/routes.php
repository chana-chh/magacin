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
    // Korisnici
    $group->get('/korisnik-lista', \App\Controllers\KorisnikController::class . ':getKorisnikLista')->setName('korisnik.lista');
    $group->post('/korisnik-brisanje', \App\Controllers\KorisnikController::class . ':postKorisnikBrisanje')->setName('korisnik.brisanje');
    $group->post('/korisnik-dodavanje', \App\Controllers\KorisnikController::class . ':postKorisnikDodavanje')->setName('korisnik.dodavanje');
    $group->get('/korisnik-izmena/{id}', \App\Controllers\KorisnikController::class . ':getKorisnikIzmena')->setName('korisnik.izmena.get');
    $group->post('/korisnik-izmena', \App\Controllers\KorisnikController::class . ':postKorisnikIzmena')->setName('korisnik.izmena.post');

    // Logovi
    $group->get('/log-lista', \App\Controllers\LogController::class . ':getLogLista')->setName('log.lista');
    // Jedinice mere
    $group->get('/jedinica-mere-lista', \App\Controllers\JediniceMereController::class . ':getJedinicaMereLista')->setName('jedinica.mere.lista');
    $group->post('/jedinica-mere-dodavanje', \App\Controllers\JediniceMereController::class . ':postJedinicaMereDodavanje')->setName('jedinica.mere.dodavanje');
    $group->get('/jedinica-mere-izmena/{id}', \App\Controllers\JediniceMereController::class . ':getJedinicaMereIzmena')->setName('jedinica.mere.izmena.get');
    $group->post('/jedinica-mere-brisanje', \App\Controllers\JediniceMereController::class . ':postJedinicaMereBrisanje')->setName('jedinica.mere.brisanje');
    $group->post('/jedinica-izmena', \App\Controllers\JediniceMereController::class . ':postJedinicaMereIzmena')->setName('jedinica.mere.izmena');

    $group->get('/odjava', App\Controllers\AuthController::class . ':getOdjava')->setName('odjava');
})->add(new AuthMiddleware($container));
