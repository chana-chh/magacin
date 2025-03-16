<?php

namespace App\Middlewares;

use App\Classes\Auth;
use App\Classes\Middleware;
use Slim\Routing\RouteContext;

class GuestMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $auth = $this->container->get(Auth::class);
        if ($auth->isLoggedIn()) {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('pocetna');

            return $response
                ->withHeader('Location', $url)
                ->withStatus(302);
        }
        return $next($request, $response);
    }
}
