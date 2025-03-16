<?php

namespace App\Middlewares;

use Slim\Views\Twig;
use App\Classes\Auth;
use App\Classes\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class UserMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $aut = $this->container->get(Auth::class);

        $korisnik = [
            'id' => $aut->korisnik()->id,
            'puno_ime' => $aut->korisnik()->puno_ime,
            'nivo' => $aut->korisnik()->nivo,
            'prijavljen' => $aut->isLoggedIn(),
        ];

        $twig = $this->container->get(Twig::class);
        $twig->getEnvironment()->addGlobal('korisnik', $korisnik);

        return $handler->handle($request);
    }
}
