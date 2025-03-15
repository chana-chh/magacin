<?php

use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Middlewares\AfterMiddleware;
use App\Middlewares\BeforeMiddleware;

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(Guard::class);
$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));
$app->add(new BeforeMiddleware($container));
$app->add(new AfterMiddleware($container));
