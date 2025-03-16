<?php

use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Middlewares\CsrfMiddleware;
use App\Middlewares\UserMiddleware;

$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));
$app->add(new UserMiddleware($container));
$app->add(new CsrfMiddleware($container));
$app->add(Guard::class);
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
