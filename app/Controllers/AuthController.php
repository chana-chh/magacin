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
        // CSRF token name and value
        $csrf = $this->container->get(Guard::class);
        $nameKey = $csrf->getTokenNameKey();
        $valueKey = $csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);

        $csrf = "
        <input type=\"hidden\" name=\"{$nameKey}\" value=\"{$name}\">
        <input type=\"hidden\" name=\"{$valueKey}\" value=\"{$value}\">
        ";

        return $this->render($response, 'prijava.twig', ['csrf' => $csrf]);
    }

    public function postPrijava(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        $username = $data['korisnicko_ime'];
        $password = $data['lozinka'];

        $ok = $this->container->get(Auth::class)->login($username, $password);

        if ($ok) {
            return $this->redirect($request, $response, 'pocetna');
        }

        return $this->redirect($request, $response, 'prijava');
    }

    public function getOdjava(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}
