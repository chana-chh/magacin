<?php

namespace App\Classes;

use Slim\Views\Twig;
use App\Classes\Logger;
use App\Models\Korisnik;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Psr\Container\ContainerInterface;

class Controller
{
    protected $korisnik;
    protected $logger;
    protected $validator;
    // tip za logger
    const DODAVANJE = "ДОДАВАЊЕ";
    const IZMENA = "ИЗМЕНА";
    const BRISANJE = "БРИСАЊЕ";
    const UPLOAD = "ПРИЛАГАЊЕ";

    public function __construct(protected ContainerInterface $container)
    {
        $this->validator = $container->get(Validator::class);
        $auth = $container->get(Auth::class);
        $this->korisnik = $auth->korisnik();
        $this->logger = new Logger($this->korisnik->id);
    }

    protected function validator()
    {
        return $this->container->get(Validator::class);
    }

    protected function log($tip, $opis, $model = null, $model_stari = null)
    {
        $this->logger->log($tip, $opis, $model, $model_stari);
    }

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

    protected function data($request)
    {
        $data = $request->getParsedBody();
        unset($data['csrf_name']);
        unset($data['csrf_value']);
        return $data;
    }
}
