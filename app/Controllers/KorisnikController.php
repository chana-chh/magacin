<?php

namespace App\Controllers;

use App\Classes\Controller;
use \App\Models\Korisnik;
use App\Classes\Logger;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class KorisnikController extends Controller
{
    public function getKorisnikLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new Korisnik();
        $data = $model->all();
        return $this->render($response, 'korisnici/lista.twig', compact('data'));
    }

    public function postKorisnikDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        $validation_rules = [
            'puno_ime' => [
                'required' => true,
                'alnum' => true,
            ],
            'korisnicko_ime' => [
                'required' => true,
                'minlen' => 5,
                'maxlen' => 50,
                'alnum' => true,
                'unique' => 'korisnici.korisnicko_ime',
            ],
            'lozinka' => [
                'required' => true,
                'minlen' => 6,
            ],
            'lozinka_potvrda' => [
                'match_field' => 'lozinka',
            ],
            'nivo' => [
                'required' => true
            ]
        ];
        
            $modelKorisnik = new Korisnik();
            unset($data['lozinka_potvrda']);
            unset($data['csrf_name']);
            unset($data['csrf_value']);
            $data['lozinka'] = password_hash($data['lozinka'], PASSWORD_DEFAULT);
            $modelKorisnik->insert($data);
            $korisnik = $modelKorisnik->find($modelKorisnik->getLastId());
            return $this->redirect($request, $response, 'korisnik.lista');
    }
}
