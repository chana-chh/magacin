<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\Stanje;
use App\Models\Artikal;
use App\Models\Magacin;
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

    public function getStanjeMagacin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_magacina = (int) $request->getAttribute('id');
        $stanje = [];
        $mag = new Magacin();
        $magacin = null;
        if ($id_magacina !== 0) {
            $sql = "SELECT id_artikla, SUM(kolicina) AS kolicina FROM stanje WHERE id_magacina = :id_magacina GROUP BY id_artikla ORDER BY kolicina DESC;";
            $stanje = (new Stanje())->fetch($sql, [':id_magacina' => $id_magacina]);
            $magacin = $mag->find($id_magacina);
        }
        $magacini = $mag->all();
        return $this->render($response, 'stanje/lista_1.twig', compact('stanje', 'magacini', 'magacin'));
    }

    public function getStanjeArtikal(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_artikla = (int) $request->getAttribute('id');
        $stanje = [];
        $art = new Artikal();
        $artikal = null;
        if ($id_artikla !== 0) {
            $sql = "SELECT * FROM stanje WHERE id_artikla = :id_artikla;";
            $stanje = (new Stanje())->fetch($sql, [':id_artikla' => $id_artikla]);
            $artikal = $art->find($id_artikla);
        }
        $artikli = $art->all();
        return $this->render($response, 'stanje/lista_1.twig', compact('stanje', 'artikli', 'artikal'));
    }
}
