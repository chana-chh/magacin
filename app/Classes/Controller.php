<?php

namespace App\Classes;

use Slim\Views\Twig;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Psr\Container\ContainerInterface;

class Controller
{
    public function __construct(protected ContainerInterface $container) {}

    public function redirect($request, $response, $route_name, $params = [])
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor($route_name, $params);

        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }

    protected function render($response, $template, $vars = [])
    {
        $twig = $this->container->get(Twig::class);
        return $twig->render($response, $template, $vars);
    }

    protected function flash($key, $message)
    {
        return $this->container->get(Messages::class)->addMessage($key, $message);
    }

    // protected function addCsrfToken(array &$data)
    // {
    //     $data['csrf_name'] = $this->csrf->getTokenName();
    //     $data['csrf_value'] = $this->csrf->getTokenValue();
    // }

    // protected function log($tip, $model, $polje, $model_stari = null)
    // {
    //     $this->logger->log($tip, $model, $polje, $model_stari);
    // }
}
