<?php

namespace App\Middlewares;

use App\Classes\Auth;
use App\Classes\Middleware;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class GuestMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $auth = $this->container->get(Auth::class);
        if ($auth->isLoggedIn()) {
            // $this->flash->addMessage('warning', 'Samo za Ne prijavljene korisnike');
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('pocetna');
            return $response->withHeader('Location', $url)->withStatus(302);
        }
        return $response;
    }
}
