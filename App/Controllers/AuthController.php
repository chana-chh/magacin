<?php

namespace App\Controllers;

use App\Classes\Logger;

class AuthController extends Controller
{
    public function getPrijava($request, $response)
    {
        dd("AuthController.getPrijava");
        $this->render($response, 'auth/prijava.twig');
    }

    public function postPrijava($request, $response)
    {
        $ok = $this->auth->login($request->getParam('korisnicko_ime'), $request->getParam('lozinka'));
        if ($ok) {
            $this->flash->addMessage('success', 'Корисник је успешно пријављен.');
            return $response->withRedirect($this->router->pathFor('pocetna'));
        } else {
            $this->flash->addMessage('danger', 'Подаци за пријаву корисника нису исправни.');
            return $response->withRedirect($this->router->pathFor('prijava'));
        }
    }

    public function getOdjava($request, $response)
    {
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('pocetna'));
    }

    public function getPromena($request, $response)
    {
        $this->render($response, 'auth/promena.twig');
    }

    public function postPromena($request, $response)
    {
        $data = $request->getParams();

        $validation_rules = [
            'lozinka' => [
                'required' => true
            ],
            'nova_lozinka' => [
                'required' => true,
                'minlen' => 6,
            ],
            'lozinka_potvrda' => [
                'required' => true,
                'match_field' => 'nova_lozinka',
            ],
        ];

        $this->validator->validate($data, $validation_rules);

        if ($this->validator->hasErrors()) {
            $this->flash->addMessage('danger', 'Дошло је до грешке приликом промене лизинке');
            return $response->withRedirect($this->router->pathFor('promena'));
        } else {
            $prijavljeni_korisnik = $this->auth->user();
            $dobra_lozinka = $this->auth->checkPassword($data['lozinka'], $prijavljeni_korisnik->lozinka);
            if ($dobra_lozinka) {
                $novi_hash = password_hash($data['nova_lozinka'], PASSWORD_DEFAULT);
                $prijavljeni_korisnik->update(['lozinka' => $novi_hash], $prijavljeni_korisnik->id);
                $this->log(Logger::IZMENA, $prijavljeni_korisnik, 'korisnicko_ime');
                $this->flash->addMessage('success', 'Лозинка је успешно промењена. Потребно је да се понови пријавите са новом лозинком.');
                $this->auth->logout();
                return $response->withRedirect($this->router->pathFor('prijava'));
            } else {
                $this->flash->addMessage('danger', 'Дошло је до грешке приликом промене лизинке. Потребно је да се понови пријавите са старом лозинком.');
                $this->auth->logout();
                return $response->withRedirect($this->router->pathFor('prijava'));
            }
        }
    }
}
