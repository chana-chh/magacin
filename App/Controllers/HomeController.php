<?php

namespace App\Controllers;

use App\Classes\Auth;
use App\Classes\Logger;
use App\Models\Termin;
use App\Models\Sala;
use App\Models\TipDogadjaja;
use App\Models\Podesavanje;

class HomeController extends Controller
{
    public function getHome($request, $response)
    {
        dd("HomeController.getHome");
        $this->render($response, 'home.twig');
    }
}
