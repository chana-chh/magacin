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
        $where_data = [];
        if (isset($_SESSION['MAGACIN_LOG_PRETRAGA'])) {
            $where_data = $_SESSION['MAGACIN_LOG_PRETRAGA'];
            unset($_SESSION['MAGACIN_LOG_PRETRAGA']);
        }

        d(empty($where_data), false);

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

    public function postLogPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_LOG_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'log.lista');
    }

    private function compileWhere(array $where_data): string
    {
        $where = [];
        foreach ($where_data as $key => $value) {
            $where[] = "$key = '$value'";
        }
        return implode(' AND ', $where);
    }
}
