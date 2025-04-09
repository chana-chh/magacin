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

    // Tipovi naloga
    $group->get('/tip-naloga-lista', \App\Controllers\TipNalogaController::class . ':getTipNalogaLista')->setName('tip.naloga.lista');
    $group->post('/tip-naloga-dodavanje', \App\Controllers\TipNalogaController::class . ':postTipNalogaDodavanje')->setName('tip.naloga.dodavanje');
    $group->get('/tip-naloga-izmena/{id}', \App\Controllers\TipNalogaController::class . ':getTipNalogaIzmena')->setName('tip.naloga.izmena.get');
    $group->post('/tip-naloga-brisanje', \App\Controllers\TipNalogaController::class . ':postTipNalogaBrisanje')->setName('tip.naloga.brisanje');
    $group->post('/tip-naloga-izmena', \App\Controllers\TipNalogaController::class . ':postTipNalogaIzmena')->setName('tip.naloga.izmena');

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
    $group->get('/dodavljac-dodavanje', \App\Controllers\DobavljacController::class . ':getDobavljacDodavanje')->setName('dobavljac.dodavanje.get');
    $group->post('/dodavljac-dodavanje', \App\Controllers\DobavljacController::class . ':postDobavljacDodavanje')->setName('dobavljac.dodavanje');
    $group->get('/dodavljac-izmena/{id}', \App\Controllers\DobavljacController::class . ':getDobavljacIzmena')->setName('dobavljac.izmena.get');
    $group->post('/dodavljac-brisanje', \App\Controllers\DobavljacController::class . ':postDobavljacBrisanje')->setName('dobavljac.brisanje');
    $group->post('/dodavljac-izmena', \App\Controllers\DobavljacController::class . ':postDobavljacIzmena')->setName('dobavljac.izmena');
    $group->post('/dodavljac-pretraga', \App\Controllers\DobavljacController::class . ':postDobavljacPretraga')->setName('dobavljac.pretraga.post');
    $group->get('/dodavljac-pretraga', \App\Controllers\DobavljacController::class . ':getDobavljacPretraga')->setName('dobavljac.pretraga.get');

    // Kupci
    $group->get('/kupac-lista', \App\Controllers\KupacController::class . ':getKupacLista')->setName('kupac.lista');
    $group->get('/kupac-dodavanje', \App\Controllers\KupacController::class . ':getKupacDodavanje')->setName('kupac.dodavanje.get');
    $group->post('/kupac-dodavanje', \App\Controllers\KupacController::class . ':postKupacDodavanje')->setName('kupac.dodavanje');
    $group->get('/kupac-izmena/{id}', \App\Controllers\KupacController::class . ':getKupacIzmena')->setName('kupac.izmena.get');
    $group->post('/kupac-brisanje', \App\Controllers\KupacController::class . ':postKupacBrisanje')->setName('kupac.brisanje');
    $group->post('/kupac-izmena', \App\Controllers\KupacController::class . ':postKupacIzmena')->setName('kupac.izmena');
    $group->post('/kupac-pretraga', \App\Controllers\KupacController::class . ':postKupacPretraga')->setName('kupac.pretraga.post');
    $group->get('/kupac-pretraga', \App\Controllers\KupacController::class . ':getKupacPretraga')->setName('kupac.pretraga.get');

    //Prijemnice
    $group->get('/prijemnica-lista', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaLista')->setName('prijemnica.lista');
    $group->get('/prijemnica-dodavanje', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaDodavanje')->setName('prijemnica.dodavanje.get');
    $group->post('/prijemnica-dodavanje', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaDodavanje')->setName('prijemnica.dodavanje.post');
    $group->get('/prijemnica-izmena/{id:[0-9]+}', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaIzmena')->setName('prijemnica.izmena.get');
    $group->post('/prijemnica-izmena', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaIzmena')->setName('prijemnica.izmena.post');
    $group->post('/prijemnica-pretraga', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaPretraga')->setName('prijemnica.pretraga.post');
    $group->get('/prijemnica-pretraga', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaPretraga')->setName('prijemnica.pretraga.get');
    $group->post('/prijemnica-brisanje', \App\Controllers\PrijemnicaController::class . ':postPrijemnicaBrisanje')->setName('prijemnica.brisanje');
    $group->get('/prijemnica-pregled/{id:[0-9]+}', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaPregled')->setName('prijemnica.pregled');
    $group->get('/prijemnica-pregled-no/{id:[0-9]+}', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaPregledNo')->setName('prijemnica.pregled.no');
    $group->get('/prijemnica-dobavljac/{id:[0-9]+}', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaDobavljac')->setName('prijemnica.dobavljac');
    $group->get('/prijemnica-magacin/{id:[0-9]+}', \App\Controllers\PrijemnicaController::class . ':getPrijemnicaMagacin')->setName('prijemnica.magacin');
    // Prijemnica stavke
    $group->post('/prijemnica-stavke-dodavanje', \App\Controllers\PrijemnicaArtikalController::class . ':postPrijemnicaStavkeDodavanje')->setName('prijemnica.stavke.dodavanje');
    $group->post('/prijemnica-stavke-brisanje', \App\Controllers\PrijemnicaArtikalController::class . ':postPrijemnicaStavkeBrisanje')->setName('prijemnica.stavke.brisanje');
    $group->post('/prijemnica-stavke-placanje', \App\Controllers\PrijemnicaArtikalController::class . ':postPrijemnicaStavkePlacanje')->setName('prijemnica.stavke.placanje');

    //Otpremnice
    $group->get('/otpremnica-lista', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaLista')->setName('otpremnica.lista');
    $group->get('/otpremnica-dodavanje', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaDodavanje')->setName('otpremnica.dodavanje.get');
    $group->post('/otpremnica-dodavanje', \App\Controllers\OtpremnicaController::class . ':postOtpremnicaDodavanje')->setName('otpremnica.dodavanje.post');
    $group->get('/otpremnica-izmena/{id:[0-9]+}', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaIzmena')->setName('otpremnica.izmena.get');
    $group->post('/otpremnica-izmena', \App\Controllers\OtpremnicaController::class . ':postOtpremnicaIzmena')->setName('otpremnica.izmena.post');
    $group->post('/otpremnica-pretraga', \App\Controllers\OtpremnicaController::class . ':postOtpremnicaPretraga')->setName('otpremnica.pretraga.post');
    $group->get('/otpremnica-pretraga', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaPretraga')->setName('otpremnica.pretraga.get');
    $group->post('/otpremnica-brisanje', \App\Controllers\OtpremnicaController::class . ':postOtpremnicaBrisanje')->setName('otpremnica.brisanje');
    $group->get('/otpremnica-pregled/{id:[0-9]+}', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaPregled')->setName('otpremnica.pregled');
    $group->get('/otpremnica-pregled-no/{id:[0-9]+}', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaPregledNo')->setName('otpremnica.pregled.no');
    $group->get('/otpremnica-kupac/{id:[0-9]+}', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaKupac')->setName('otpremnica.kupac');
    $group->get('/otpremnica-magacin/{id:[0-9]+}', \App\Controllers\OtpremnicaController::class . ':getOtpremnicaMagacin')->setName('otpremnica.magacin');
    // otpremnica stavke
    $group->post('/otpremnica-stavke-dodavanje', \App\Controllers\OtpremnicaArtikalController::class . ':postOtpremnicaStavkeDodavanje')->setName('otpremnica.stavke.dodavanje');
    $group->post('/otpremnica-stavke-brisanje', \App\Controllers\OtpremnicaArtikalController::class . ':postOtpremnicaStavkeBrisanje')->setName('otpremnica.stavke.brisanje');
    $group->post('/otpremnica-stavke-placanje', \App\Controllers\OtpremnicaArtikalController::class . ':postOtpremnicaStavkePlacanje')->setName('otpremnica.stavke.placanje');

    //Stanje
    $group->get('/stanje-lista-ukupno', \App\Controllers\StanjeController::class . ':getUkupnoLista')->setName('stanje.lista.ukupno');
    $group->post('/stanje-ukupno-pretraga', \App\Controllers\StanjeController::class . ':postUkupnoListaPretraga')->setName('stanje.ukupno.pretraga.post');
    $group->get('/stanje-ukupno-pretraga', \App\Controllers\StanjeController::class . ':getUkupnoListaPretraga')->setName('stanje.ukupno.pretraga.get');
    $group->get('/stanje-magacin/{id:[0-9]+}', \App\Controllers\StanjeController::class . ':getStanjeMagacin')->setName('stanje.magacin');
    $group->get('/stanje-artikal/{id:[0-9]+}', \App\Controllers\StanjeController::class . ':getStanjeArtikal')->setName('stanje.artikal');
    $group->get('/kartica-artikla/{id:[0-9]+}', \App\Controllers\StanjeController::class . ':getKarticaArtikla')->setName('kartica.artikla');

    //Nalozi
    $group->get('/nalog-lista', \App\Controllers\NalogController::class . ':getNalogLista')->setName('nalog.lista');
    $group->get('/nalog-dodavanje', \App\Controllers\NalogController::class . ':getNalogDodavanje')->setName('nalog.dodavanje.get');
    $group->post('/nalog-dodavanje', \App\Controllers\NalogController::class . ':postNalogDodavanje')->setName('nalog.dodavanje.post');
    $group->get('/nalog-izmena/{id:[0-9]+}', \App\Controllers\NalogController::class . ':getNalogIzmena')->setName('nalog.izmena.get');
    $group->post('/nalog-izmena', \App\Controllers\NalogController::class . ':postNalogIzmena')->setName('nalog.izmena.post');
    $group->post('/nalog-pretraga', \App\Controllers\NalogController::class . ':postNalogPretraga')->setName('nalog.pretraga.post');
    $group->get('/nalog-pretraga', \App\Controllers\NalogController::class . ':getNalogPretraga')->setName('nalog.pretraga.get');
    $group->post('/nalog-brisanje', \App\Controllers\NalogController::class . ':postNalogBrisanje')->setName('nalog.brisanje');
    $group->get('/nalog-pregled/{id:[0-9]+}', \App\Controllers\NalogController::class . ':getNalogPregled')->setName('nalog.pregled');
    $group->get('/nalog-pregled-no/{id:[0-9]+}', \App\Controllers\NalogController::class . ':getNalogPregledNo')->setName('nalog.pregled.no');
    $group->get('/nalog-kupac/{id:[0-9]+}', \App\Controllers\NalogController::class . ':getNalogMagacinIz')->setName('nalog.magaciniz');
    $group->get('/nalog-magacin/{id:[0-9]+}', \App\Controllers\NalogController::class . ':getNalogMagacinU')->setName('nalog.magacinu');

    // Nalozi stavke
    $group->post('/nalog-stavke-dodavanje', \App\Controllers\NalogArtikalController::class . ':postNalogStavkeDodavanje')->setName('nalog.stavke.dodavanje');
    $group->post('/nalog-stavke-brisanje', \App\Controllers\NalogArtikalController::class . ':postNalogStavkeBrisanje')->setName('nalog.stavke.brisanje');

    // Popisi
    $group->get('/popis-lista', \App\Controllers\PopisController::class . ':getPopisLista')->setName('popis.lista');
    $group->post('/popis-dodavanje', \App\Controllers\PopisController::class . ':postPopisDodavanje')->setName('popis.dodavanje.post');
    $group->get('/popis-izmena/{id:[0-9]+}', \App\Controllers\PopisController::class . ':getPopisIzmena')->setName('popis.izmena.get');
    $group->post('/popis-izmena', \App\Controllers\PopisController::class . ':postPopisIzmena')->setName('popis.izmena.post');
    $group->post('/popis-pretraga', \App\Controllers\PopisController::class . ':postPopisPretraga')->setName('popis.pretraga.post');
    $group->get('/popis-pretraga', \App\Controllers\PopisController::class . ':getPopisPretraga')->setName('popis.pretraga.get');
    $group->post('/popis-brisanje', \App\Controllers\PopisController::class . ':postPopisBrisanje')->setName('popis.brisanje');
    $group->get('/popis-pregled/{id:[0-9]+}', \App\Controllers\PopisController::class . ':getPopisPregled')->setName('popis.pregled');
    $group->get('/popis-lista-pregled', \App\Controllers\PopisController::class . ':getPopisListaPregled')->setName('popis.lista.pregled.get');
    $group->get('/popis-stavke-pregled/{id:[0-9]+}', \App\Controllers\PopisController::class . ':getPopisStavkaPregled')->setName('popis.satvke.pregled.get');
    $group->post('/popis-pregled-pretraga', \App\Controllers\PopisController::class . ':postPopisPregledPretraga')->setName('popis.pregled.pretraga.post');
    $group->get('/popis-pregled-pretraga', \App\Controllers\PopisController::class . ':getPopisPregledPretraga')->setName('popis.pregled.pretraga.get');
    $group->post('/popis-zakljucavanje', \App\Controllers\PopisController::class . ':postPopisZakljucavanje')->setName('popis.zakljucavanje');
    // Popis stavke
    $group->post('/popis-stavke-dodavanje', \App\Controllers\PopisArtikalController::class . ':postPopisStavkeDodavanje')->setName('popis.stavke.dodavanje');
    $group->post('/popis-stavke-brisanje', \App\Controllers\PopisArtikalController::class . ':postPopisStavkeBrisanje')->setName('popis.stavke.brisanje');

    // Otpisi
    $group->get('/otpis-lista', \App\Controllers\OtpisController::class . ':getOtpisLista')->setName('otpis.lista');
    $group->post('/otpis-dodavanje', \App\Controllers\OtpisController::class . ':postOtpisDodavanje')->setName('otpis.dodavanje.post');
    $group->post('/otpis-pretraga', \App\Controllers\OtpisController::class . ':postOtpisPretraga')->setName('otpis.pretraga.post');
    $group->get('/otpis-pretraga', \App\Controllers\OtpisController::class . ':getOtpisPretraga')->setName('otpis.pretraga.get');
    $group->post('/otpis-brisanje', \App\Controllers\OtpisController::class . ':postOtpisBrisanje')->setName('otpis.brisanje');
    $group->get('/otpis-artikal/{id:[0-9]+}', \App\Controllers\OtpisController::class . ':getOtpisArtikal')->setName('otpis.artikal');

    // Kartica artikla

    $group->get('/odjava', App\Controllers\AuthController::class . ':getOdjava')->setName('odjava');
})->add(new AuthMiddleware($container));
