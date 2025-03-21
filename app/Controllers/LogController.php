<?php

namespace App\Controllers;

use App\Models\Log;
use App\Classes\Controller;
use App\Models\Korisnik;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogController extends Controller
{
    public function getLogLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;
        $modelLog = new Log();
        $tables = $modelLog->fetchAssoc("SHOW TABLES;");
        $tabele = [];
        foreach ($tables as $key => $value) {
            $tabele[] = $value['Tables_in_magacin'];
        }

        $korisnici = (new Korisnik())->all('puno_ime');

        $sql = "SELECT * FROM logovi ORDER BY vreme DESC;";
        $logovi = $modelLog->paginate($path, $page, $sql, [], 2, 3);
        return $this->render($response, 'logovi.twig', compact('logovi', 'tabele', 'korisnici'));
    }
}
