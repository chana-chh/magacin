<?php

use Slim\Csrf\Guard;
use Slim\Views\Twig;
use App\Classes\Auth;
use Slim\Flash\Messages;
use App\Classes\TwigMessages;
use App\Classes\Validator;
use Slim\Psr7\Factory\ResponseFactory;

$builder = new \DI\ContainerBuilder();
$container = $builder->addDefinitions([
    "settings" => $config["settings"],
    Auth::class => fn() => new Auth(),
    Validator::class => fn() => new Validator(),
    Twig::class => function () {
        $twig = Twig::create(DIR . 'app/views', ['cache' => false]);
        $twig->addExtension(new TwigMessages(new Messages));
        return $twig;
    },
    Guard::class => fn() => new Guard(new ResponseFactory()),
    Messages::class => fn() => new Messages(),
]);

$container = $container->build();

$app = \DI\Bridge\Slim\Bridge::create($container);
$app->setBasePath("/magacin/pub");
