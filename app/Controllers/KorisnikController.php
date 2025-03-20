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
        $data = $this->data($request);
        $rules = [
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
            
            $this->validator()->validate($data, $rules);
            if ($this->validator()->hasErrors()) {
                $this->flash('danger', 'Неуспешно додавање корисника');
                return $this->redirect($request, $response, 'korisnik.lista');
            }
            $modelKorisnik = new Korisnik();
            $data['lozinka'] = password_hash($data['lozinka'], PASSWORD_DEFAULT);
            unset($data['lozinka_potvrda']);
            $id = $modelKorisnik->insert($data);
            $zalog = $modelKorisnik->find($id);
            $this->log($this::DODAVANJE, 'Додавање корисника', $zalog);
            $this->flash('success', 'Успешно додавање корисника');

            return $this->redirect($request, $response, 'korisnik.lista');
    }

    public function postKorisnikBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $korisnik = new Korisnik();
        $model = $korisnik->find($id);
        $ok = $korisnik->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање корисника');
            return $this->redirect($request, $response, 'korisnik.lista');
        }
        $this->log($this::BRISANJE, 'Брисање корисника', $model);
        $this->flash('success', 'Успешно брисање корисника');
        return $this->redirect($request, $response, 'korisnik.lista');
    }

    public function getKorisnikIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new Korisnik();
        $kor = $model->find($id);
        return $this->render($response, 'korisnici/izmena.twig', compact('kor'));
    }

    public function postKorisnikIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);

        $rules_data = [
            'puno_ime' => [
                'required' => true,
                'alnum' => true,
            ],
            'korisnicko_ime' => [
                'required' => true,
                'minlen' => 5,
                'maxlen' => 50,
                'alnum' => true,
                'unique' => 'korisnici.korisnicko_ime#id:'.$id
            ],
            'nivo' => [
                'required' => true
            ]
        ];

        $rules_pass = [
            'lozinka' => [
                'required' => true,
                'minlen' => 6,
            ],
            'lozinka_potvrda' => [
                'match_field' => 'lozinka',
            ]
        ];
        
        if (!empty($data['lozinka'])) {
            array_push($rules_data, $rules_pass);
        }
            $this->validator()->validate($data, $rules_data);
            if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена корисника');
            
            return $this->redirect($request, $response, 'korisnik.izmena.get', ['id' => $id]);
        }   else {
            $this->flash('success', 'Подаци о кориснику су успешно измењени.');
            $modelKorisnik = new Korisnik();
            $stari = $modelKorisnik->find($id);
            unset($data['lozinka_potvrda']);
            if (!empty($data['lozinka'])) {
                $data['lozinka'] = password_hash($data['lozinka'], PASSWORD_DEFAULT);
            } else {
                unset($data['lozinka']);
            }
            $modelKorisnik->update($data, $id);
            $korisnik = $modelKorisnik->find($id);
            $this->log($this::IZMENA, 'Измена корисника', $korisnik, $stari);
            return $this->redirect($request, $response, 'korisnik.lista');
        }
    }
}
