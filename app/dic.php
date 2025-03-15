<?php

use Slim\Csrf\Guard;
use Slim\Views\Twig;
use App\Classes\Auth;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ResponseFactory;

$builder = new \DI\ContainerBuilder();

$container = $builder->addDefinitions([
    "settings" => $config["settings"],
    Auth::class => fn(ContainerInterface $container) => new Auth($container),
    Twig::class => fn() => Twig::create(DIR . 'app/views', ['cache' => false]),
    Guard::class => fn() => new Guard(new ResponseFactory()),
])->build();

$app = \DI\Bridge\Slim\Bridge::create($container);
