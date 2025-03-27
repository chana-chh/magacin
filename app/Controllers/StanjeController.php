<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\Stanje;
use App\Models\Artikal;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StanjeController extends Controller
{
    public function getUkupnoLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['STANJE_UKUPNO_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $sta = new Stanje();
        $sql = "SELECT id_artikla,SUM(kolicina) AS ukupno FROM stanje GROUP BY id_artikla ORDER BY ukupno ASC;";
        $stanje = $sta->paginate($path, $page, $sql, [], null, 3);
        $artikli = (new Artikal())->all();

        return $this->render($response, 'stanje/ukupno_lista.twig', compact('stanje', 'artikli'));
    }

    public function postUkupnoListaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['STANJE_UKUPNO_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'stanje.ukupno.pretraga.get');
    }

        public function getUkupnoListaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['STANJE_UKUPNO_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];


        if (!empty($data['id_artikla'])) {
            $conditions[] = 'id_artikla = :id_artikla';
            $params[':id_artikla'] = $data['id_artikla'];
        }


        if (empty($conditions)) {
            return $this->redirect($request, $response, 'stanje.lista.ukupno');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $sta = new Stanje();
        $artikli = (new Artikal())->all();

        // Logovi
        $sql = "SELECT id_artikla,SUM(kolicina) AS ukupno FROM stanje {$where} GROUP BY id_artikla ORDER BY ukupno ASC;";
        $stanje = $sta->paginate($path, $page, $sql, $params);
        return $this->render($response, 'stanje/ukupno_lista.twig', compact('stanje', 'artikli', 'data'));
    }
}
