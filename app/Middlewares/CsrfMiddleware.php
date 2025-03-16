<?php

namespace App\Middlewares;

use Slim\Csrf\Guard;
use Slim\Views\Twig;
use App\Classes\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CsrfMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $guard = $this->container->get(Guard::class);

        $name = $guard->getTokenName();
        $nameKey = $guard->getTokenNameKey();
        $value = $guard->getTokenValue();
        $valueKey = $guard->getTokenValueKey();
        $csrf = "
        <input type=\"hidden\" name=\"{$nameKey}\" value=\"{$name}\">
        <input type=\"hidden\" name=\"{$valueKey}\" value=\"{$value}\">
        ";

        $twig = $this->container->get(Twig::class);
        $twig->getEnvironment()->addGlobal('csrf', $csrf);

        return $handler->handle($request);
    }
}
