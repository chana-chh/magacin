<?php

namespace App\Middlewares;

use Slim\Views\Twig;
use App\Classes\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class OldMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (isset($_SESSION['old'])) {
            $twig = $this->container->get(Twig::class);
            $twig->getEnvironment()->addGlobal('old', $_SESSION['old']);
        }
        $_SESSION['old'] = $request->getParsedBody();

        return $handler->handle($request);
    }
}
