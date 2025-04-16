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
        $sql = "SELECT id_artikla, SUM(kolicina) AS ukupno FROM stanje GROUP BY id_artikla ORDER BY ukupno ASC;";
        $stanje = $sta->paginate($path, $page, $sql, []);
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
        $sql = "SELECT id_artikla, SUM(kolicina) AS ukupno FROM stanje {$where} GROUP BY id_artikla ORDER BY ukupno ASC;";
        $stanje = $sta->paginate($path, $page, $sql, $params);
        return $this->render($response, 'stanje/ukupno_lista.twig', compact('stanje', 'artikli', 'data'));
    }

    public function getStanjeMagacin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_magacina = (int) $request->getAttribute('id');
        $sta = new Stanje();
        $stanja = [];
        $mag = new Magacin();
        $magacin = null;
        if ($id_magacina !== 0) {
            $stanja = $sta->stanjeUkupnoMagacin($id_magacina);
            $magacin = $mag->find($id_magacina);
        }
        $magacini = $mag->all();
        return $this->render($response, 'stanje/lista_magacin.twig', compact('stanja', 'magacini', 'magacin'));
    }

    public function getStanjeArtikal(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_artikla = (int) $request->getAttribute('id');
        $sta = new Stanje();
        $stanja = [];
        $art = new Artikal();
        $artikal = null;
        $ukupno_artikal = $sta->stanjeArtikal($id_artikla);
        if ($id_artikla) {
            $stanja = $sta->stanjeUkupnoArtikal($id_artikla);
            $artikal = $art->find($id_artikla);
        }
        $artikli = $art->all();
        return $this->render($response, 'stanje/lista_artikal.twig', compact('stanja', 'artikli', 'artikal', 'ukupno_artikal'));
    }

    //PRIVREMENO
    public function postStanjeDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);

        $rules = [
            'id_magacina' => [
                'required' => true,
            ],
            'id_artikla' => [
                'required' => true,
            ],
            'kolicina' => [
                'required' => true,
                'min' => 0,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање артикла на стање');
            return $this->redirect($request, $response, 'stanje.lista.ukupno');
        }

        $stanje = new Stanje();
        $id = $stanje->insert($data);
        $model = $stanje->find($id);
        $this->log($this::DODAVANJE, 'Додавање артикла на стање', $model);
        $this->flash('success', 'Успешно додавање ставке');

        return $this->redirect($request, $response, 'stanje.lista.ukupno');
    }

    public function getStanjeDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $magacini = (new Magacin())->all();
        $artikli = (new Artikal())->all();
        return $this->render($response, 'stanje/dodavanje.twig', compact('magacini', 'artikli'));
    }

    public function getStanjeIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $stanje = (new Stanje())->find($id);
        $magacini = (new Magacin())->all();
        $artikli = (new Artikal())->all();
        return $this->render($response, 'stanje/izmena.twig', compact('stanje', 'magacini', 'artikli'));
    }

    public function postStanjeIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'id_magacina' => [
                'required' => true,
            ],
            'id_artikla' => [
                'required' => true,
            ],
            'kolicina' => [
                'required' => true,
                'min' => 0,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена стања');
            return $this->redirect($request, $response, 'stanje.magacin', ['id' => $data['id_magacina']]);
        }

        $stanj = new Stanje();
        $stari = $stanj->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $stanj->update($data, $id);
        $stanje = $stanj->find($id);
        $this->log($this::IZMENA, 'Измена стања', $stanje, $stari);
        $this->flash('success', 'Успешна измена стања');

        return $this->redirect($request, $response, 'stanje.magacin', ['id' => $data['id_magacina']]);
    }

    public function postStanjeBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $sta = new Stanje();
        $model = $sta->find($id);
        $id_magacina = $model->id_magacina;

        $ok = $sta->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање артикла са стања');
            return $this->redirect($request, $response, 'stanje.magacin', ['id' => $id_magacina]);
        }

        $this->log($this::BRISANJE, 'Брисање артикла са стања', $model);
        $this->flash('success', 'Успешно брисање артикла са стања');
        return $this->redirect($request, $response, 'stanje.magacin', ['id' => $id_magacina]);
    }
}
