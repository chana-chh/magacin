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
        unset($_SESSION['MAGACIN_LOG_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $modelLog = new Log();
        // Za formu
        $tables = $modelLog->fetchAssoc("SHOW TABLES;");
        $tabele = [];
        foreach ($tables as $key => $value) {
            $tabele[] = $value['Tables_in_magacin'];
        }
        $korisnici = (new Korisnik())->all('puno_ime');

        // Logovi
        $sql = "SELECT * FROM logovi ORDER BY vreme DESC;";
        $logovi = $modelLog->paginate($path, $page, $sql, [], 2, 3);
        return $this->render($response, 'logovi.twig', compact('logovi', 'tabele', 'korisnici'));
    }

    public function postLogPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_LOG_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'log.pretraga.get');
    }

    public function getLogPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['MAGACIN_LOG_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['tip'])) {
            $conditions[] = 'tip = :tip';
            $params[':tip'] = $data['tip'];
        }

        if (!empty($data['tabela'])) {
            $conditions[] = 'tabela = :tabela';
            $params[':tabela'] = $data['tabela'];
        }

        if (!empty($data['opis'])) {
            $conditions[] = 'opis LIKE :opis';
            $params[':opis'] = '%' . $data['opis'] . '%';
        }

        if (!empty($data['korisnik'])) {
            $conditions[] = 'id_korisnika = :id_korisnika';
            $params[':id_korisnika'] = $data['korisnik'];
        }

        if (!empty($data['datum_1'])) {
            $conditions[] = 'vreme >= :vreme_od';
            $params[':vreme_od'] = $data['datum_1'];
        }

        if (!empty($data['datum_2'])) {
            $conditions[] = 'vreme <= :vreme_do';
            $params[':vreme_do'] = $data['datum_2'];
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'log.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $modelLog = new Log();
        // Za formu
        $tables = $modelLog->fetchAssoc("SHOW TABLES;");
        $tabele = [];
        foreach ($tables as $key => $value) {
            $tabele[] = $value['Tables_in_magacin'];
        }
        $korisnici = (new Korisnik())->all('puno_ime');

        // Logovi
        $sql = "SELECT * FROM logovi {$where} ORDER BY vreme DESC;";
        $logovi = $modelLog->paginate($path, $page, $sql, $params, 2, 3);
        return $this->render($response, 'logovi.twig', compact('logovi', 'tabele', 'korisnici', 'data'));
    }
}
