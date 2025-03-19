<?php

namespace App\Middlewares;

use Slim\Views\Twig;
use App\Classes\Middleware;
use App\Classes\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ErrorsMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $errors = null;
        if (isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }
        $this->container->get(Twig::class)->getEnvironment()->addGlobal('errors', $errors);

        return $handler->handle($request);
    }
}
