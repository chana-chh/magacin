<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function getHome($request, $response)
    {
        $this->flash->addMessage('success', 'Добродошли.');
        $this->render($response, 'home.twig');
    }
}
