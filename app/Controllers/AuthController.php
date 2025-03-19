<?php

namespace App\Controllers;

use Slim\Csrf\Guard;
use App\Classes\Auth;
use App\Models\Korisnik;
use App\Classes\Controller;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
    public function getPrijava(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'prijava.twig');
    }

    public function postPrijava(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $username = $data['korisnicko_ime'];
        $password = $data['lozinka'];

        $rules = [
            'korisnicko_ime' => [
                'required' => true,
                'minlen' => 5,
                'maxlen' => 50,
                'alnum' => true,
            ],
            'lozinka' => [
                'required' => true,
                'minlen' => 4,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неисправно корисничко име или лозинка');
            return $this->redirect($request, $response, 'prijava');
        }

        $ok = $this->container->get(Auth::class)->login($username, $password);

        if ($ok) {
            $this->flash('success', 'Корисник је успешно пријављен');
            return $this->redirect($request, $response, 'pocetna');
        }

        $this->flash('danger', 'Погрешно корисничко име или лозинка');
        return $this->redirect($request, $response, 'prijava');
    }

    public function getOdjava(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->container->get(Auth::class)->logout();
        $this->flash('success', 'Корисник је успешно одјављен');
        return $this->redirect($request, $response, 'pocetna');
    }
}
