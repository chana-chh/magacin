# MAGACIN

- url_for() - returns the URL for a given route. e.g.: /hello/world
- full_url_for() - returns the URL for a given route. e.g.: https://www.example.com/hello/world
- is_current_url() - returns true is the provided route name and parameters are valid for the current path.
- current_url() - returns the current path, with or without the query string.
- get_uri() - returns the UriInterface object from the incoming ServerRequestInterface object
- base_path() - returns the base path.

Pocetno stanje.

## TODO

- datum postaviti na local
- provera prilikom brisanja da li je nesto vezano za zapis koji se brise
- provera stanja prilikom brisanja prijemnica/otpremnica/nalog (da ne brise vise od trenutnog stanja)
- na prijemnicu i otpremnicu dodati:
    - nacin otpreme
    - mesto i adreca izdavanja robe (adresa magacina) - vec postoji
    - tekuci racun i pib (dodaje se na kupca i dobavljaca)
    - cena po jm (dodaje se na stavke prijemnice/otpremnice) chh
- evidencija prijema/predaje (dodaje se na prijemnicu/otpremnicu): chh
    - izdao:
        - ime i prezime
        - jmbg/lk
        - datum izdavanja
    - primio:
        - ime i prezime
        - jmbg/lk
        - datum prijema
    - prevoz:
        - ime i prezime
        - jmbg/lk
        - datum prevoza
        - registarski broj vozila
- dodati klasu za stampanje

Za prebacivanje na server
- views
    - prijemnice
        - lista.twig
        - pregled.twig
    - otpremnice
        - lista.twig
        - pregled.twig

- Models
    - Prijemnica.php
    - Otpreminca.php

- Controllers
    - PrijemnicaController.php
    - OtpremnicaController.php
    - PrijemnicaArtikalController.php
    - OtpremnicaArtikalController.php