<?php

namespace App\Controllers;

use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PocetnaController extends Controller
{
    public function getPocetna(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'pocetna.twig');
    }
}
