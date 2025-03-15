<?php

namespace App\Middlewares;

use App\Classes\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class BeforeMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // echo 'before';
        return $handler->handle($request);
    }
}
