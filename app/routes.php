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
    $group->post('/log-pretraga', \App\Controllers\LogController::class . ':postLogPretraga')->setName('log.pretraga.post');
    $group->get('/log-pretraga', \App\Controllers\LogController::class . ':getLogPretraga')->setName('log.pretraga.get');

    // Tipovi magacina
    $group->get('/tip-magacina-lista', \App\Controllers\TipMagacinaController::class . ':getTipMagacinaLista')->setName('tip.magacina.lista');
    $group->post('/tip-magacina-dodavanje', \App\Controllers\TipMagacinaController::class . ':postTipMagacinaDodavanje')->setName('tip.magacina.dodavanje');
    $group->get('/tip-magacina-izmena/{id}', \App\Controllers\TipMagacinaController::class . ':getTipMagacinaIzmena')->setName('tip.magacina.izmena.get');
    $group->post('/tip-magacina-brisanje', \App\Controllers\TipMagacinaController::class . ':postTipMagacinaBrisanje')->setName('tip.magacina.brisanje');
    $group->post('/tip-magacina-izmena', \App\Controllers\TipMagacinaController::class . ':postTipMagacinaIzmena')->setName('tip.magacina.izmena');

    // Magacini
    $group->get('/magacin-lista', \App\Controllers\MagacinController::class . ':getMagacinLista')->setName('magacin.lista');
    $group->get('/magacin-dodavanje', \App\Controllers\MagacinController::class . ':getMagacinDodavanje')->setName('magacin.dodavanje.get');
    $group->post('/magacin-dodavanje', \App\Controllers\MagacinController::class . ':postMagacinDodavanje')->setName('magacin.dodavanje.post');
    $group->get('/magacin-izmena/{id}', \App\Controllers\MagacinController::class . ':getMagacinIzmena')->setName('magacin.izmena.get');
    $group->post('/magacin-izmena', \App\Controllers\MagacinController::class . ':postMagacinIzmena')->setName('magacin.izmena.post');
    $group->post('/magacin-brisanje', \App\Controllers\MagacinController::class . ':postMagacinBrisanje')->setName('magacin.brisanje');

    // Kategorije artikala
    $group->get('/kategorija-artikla-lista', \App\Controllers\KategorijeArtikalaController::class . ':getKategorijaArtiklaLista')->setName('kategorija.artikla.lista');
    $group->post('/kategorija-artikla-dodavanje', \App\Controllers\KategorijeArtikalaController::class . ':postKategorijaArtiklaDodavanje')->setName('kategorija.artikla.dodavanje');
    $group->get('/kategorija-artikla-izmena/{id}', \App\Controllers\KategorijeArtikalaController::class . ':getKategorijaArtiklaIzmena')->setName('kategorija.artikla.izmena.get');
    $group->post('/kategorija-artikla-izmena', \App\Controllers\KategorijeArtikalaController::class . ':postKategorijaArtiklaIzmena')->setName('kategorija.artikla.izmena.post');
    $group->post('/kategorija-artikla-brisanje', \App\Controllers\KategorijeArtikalaController::class . ':postKategorijaArtiklaBrisanje')->setName('kategorija.artikla.brisanje');

    // Artikli
    $group->get('/artikal-lista', \App\Controllers\ArtikalController::class . ':getArtikalLista')->setName('artikal.lista');
    $group->get('/artikal-dodavanje', \App\Controllers\ArtikalController::class . ':getArtikalDodavanje')->setName('artikal.dodavanje.get');
    $group->post('/artikal-dodavanje', \App\Controllers\ArtikalController::class . ':postArtikalDodavanje')->setName('artikal.dodavanje.post');
    $group->get('/artikal-izmena/{id}', \App\Controllers\ArtikalController::class . ':getArtikalIzmena')->setName('artikal.izmena.get');
    $group->post('/artikal-izmena', \App\Controllers\ArtikalController::class . ':postArtikalIzmena')->setName('artikal.izmena.post');
    $group->post('/artikal-brisanje', \App\Controllers\ArtikalController::class . ':postArtikalBrisanje')->setName('artikal.brisanje');
    $group->get('/artikal-pretraga', \App\Controllers\ArtikalController::class . ':getArtikalPretraga')->setName('artikal.pretraga.get');
    $group->post('/artikal-pretraga', \App\Controllers\ArtikalController::class . ':postArtikalPretraga')->setName('artikal.pretraga.post');

    // Jedinice mere
    $group->get('/jedinica-mere-lista', \App\Controllers\JediniceMereController::class . ':getJedinicaMereLista')->setName('jedinica.mere.lista');
    $group->post('/jedinica-mere-dodavanje', \App\Controllers\JediniceMereController::class . ':postJedinicaMereDodavanje')->setName('jedinica.mere.dodavanje');
    $group->get('/jedinica-mere-izmena/{id}', \App\Controllers\JediniceMereController::class . ':getJedinicaMereIzmena')->setName('jedinica.mere.izmena.get');
    $group->post('/jedinica-mere-brisanje', \App\Controllers\JediniceMereController::class . ':postJedinicaMereBrisanje')->setName('jedinica.mere.brisanje');
    $group->post('/jedinica-izmena', \App\Controllers\JediniceMereController::class . ':postJedinicaMereIzmena')->setName('jedinica.mere.izmena');

    // Dobavljaci
    $group->get('/dodavljac-lista', \App\Controllers\DobavljacController::class . ':getDobavljacLista')->setName('dobavljac.lista');
    $group->post('/dodavljac-dodavanje', \App\Controllers\DobavljacController::class . ':postDobavljacDodavanje')->setName('dobavljac.dodavanje');
    $group->get('/dodavljac-izmena/{id}', \App\Controllers\DobavljacController::class . ':getDobavljacIzmena')->setName('dobavljac.izmena.get');
    $group->post('/dodavljac-brisanje', \App\Controllers\DobavljacController::class . ':postDobavljacBrisanje')->setName('dobavljac.brisanje');
    $group->post('/dodavljac-izmena', \App\Controllers\DobavljacController::class . ':postDobavljacIzmena')->setName('dobavljac.izmena');

    // Kupci
    $group->get('/kupac-lista', \App\Controllers\KupacController::class . ':getKupacLista')->setName('kupac.lista');
    $group->post('/kupac-dodavanje', \App\Controllers\KupacController::class . ':postKupacDodavanje')->setName('kupac.dodavanje');
    $group->get('/kupac-izmena/{id}', \App\Controllers\KupacController::class . ':getKupacIzmena')->setName('kupac.izmena.get');
    $group->post('/kupac-brisanje', \App\Controllers\KupacController::class . ':postKupacBrisanje')->setName('kupac.brisanje');
    $group->post('/kupac-izmena', \App\Controllers\KupacController::class . ':postKupacIzmena')->setName('kupac.izmena');

    //Prijemnice
    $group->get('/prijemnica-lista', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaLista')->setName('prijemnica.lista');
    $group->get('/prijemnica-dodavanje', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaDodavanje')->setName('prijemnica.dodavanje.get');
    $group->post('/prijemnica-dodavanje', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaDodavanje')->setName('prijemnica.dodavanje.post');
    $group->get('/prijemnica-izmena/{id}', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaIzmena')->setName('prijemnica.izmena.get');
    $group->post('/prijemnica-izmena', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaIzmena')->setName('prijemnica.izmena.post');
    $group->post('/prijemnica-pretraga', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaPretraga')->setName('prijemnica.pretraga.post');
    $group->get('/prijemnica-pretraga', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaPretraga')->setName('prijemnica.pretraga.get');
    $group->post('/prijemnica-brisanje', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaBrisanje')->setName('prijemnica.brisanje');

    $group->get('/odjava', App\Controllers\AuthController::class . ':getOdjava')->setName('odjava');
})->add(new AuthMiddleware($container));
