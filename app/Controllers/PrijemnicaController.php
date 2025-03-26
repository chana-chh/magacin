<?php

namespace App\Controllers;

use App\Models\Artikal;
use App\Models\Magacin;
use App\Models\Dobavljac;
use App\Models\Prijemnica;
use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PrijemnicaController extends Controller
{
    public function getPrijemnicaLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['MAGACIN_PRIJEMNICE_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();
        $dobavljaci = (new Dobavljac())->all();

        $pri = new Prijemnica();
        $sql = "SELECT * FROM prijemnice ORDER BY datum DESC;";
        $prijemnice = $pri->paginate($path, $page, $sql, []);

        return $this->render($response, 'prijemnice/lista.twig', compact('prijemnice', 'magacini', 'dobavljaci'));
    }

    public function getPrijemnicaDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $magacini = (new Magacin())->all();
        $dobavljaci = (new Dobavljac())->all();
        return $this->render($response, 'prijemnice/dodavanje.twig', compact('magacini', 'dobavljaci'));
    }

    public function postPrijemnicaDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'id_magacina' => [
                'required' => true,
            ],
            'broj' => [
                'required' => true,
                'maxlen' => 100,
            ],
            'datum' => [
                'required' => true,
            ],
            'id_dobavljaca' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање пријемнице');
            return $this->redirect($request, $response, 'prijemnica.dodavanje.get');
        }

        $pri = new Prijemnica();
        $id = $pri->insert($data);
        $model = $pri->find($id);
        $this->log($this::DODAVANJE, 'Додавање пријемнице', $model);
        $this->flash('success', 'Успешно додавање пријемнице');

        return $this->redirect($request, $response, 'prijemnica.lista');
    }

    public function getPrijemnicaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $prijemnica = (new Prijemnica())->find($id);
        $magacini = (new Magacin())->all();
        $dobavljaci = (new Dobavljac())->all();
        return $this->render($response, 'prijemnice/izmena.twig', compact('prijemnica', 'magacini', 'dobavljaci'));
    }

    public function postPrijemnicaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'id_magacina' => [
                'required' => true,
            ],
            'broj' => [
                'required' => true,
                'maxlen' => 100,
            ],
            'datum' => [
                'required' => true,
            ],
            'id_dobavljaca' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена пријемнице');
            return $this->redirect($request, $response, 'prijemnica.izmena.get', ['id' => $id]);
        }

        $pri = new Prijemnica();
        $stari = $pri->find($id);
        $pri->update($data, $id);
        $prijemnica = $pri->find($id);
        $this->log($this::IZMENA, 'Измена пријемнице', $prijemnica, $stari);
        $this->flash('success', 'Успешна измена пријемнице');

        return $this->redirect($request, $response, 'prijemnica.lista');
    }

    public function postPrijemnicaBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $pri = new Prijemnica();
        $model = $pri->find($id);
        $ok = $pri->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање пријемнице');
            return $this->redirect($request, $response, 'prijemnica.lista');
        }

        $this->log($this::BRISANJE, 'Брисање пријемнице', $model);
        $this->flash('success', 'Успешно брисање пријемнице');
        return $this->redirect($request, $response, 'prijemnica.lista');
    }

    public function postPrijemnicaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_PRIJEMNICE_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'prijemnica.pretraga.get');
    }

    public function getPrijemnicaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['MAGACIN_PRIJEMNICE_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['id_magacina'])) {
            $conditions[] = 'id_magacina = :id_magacina';
            $params[':id_magacina'] = $data['id_magacina'];
        }

        if (!empty($data['broj'])) {
            $conditions[] = 'broj LIKE :broj';
            $params[':broj'] = '%' . $data['broj'] . '%';
        }

        if (!empty($data['id_dobavljaca'])) {
            $conditions[] = 'id_dobavljaca = :id_dobavljaca';
            $params[':id_dobavljaca'] = $data['id_dobavljaca'];
        }

        if (!empty($data['datum_1'])) {
            $conditions[] = 'datum >= :datum_od';
            $params[':datum_od'] = $data['datum_1'];
        }

        if (!empty($data['datum_2'])) {
            $conditions[] = 'datum >= :datum_do';
            $params[':datum_do'] = $data['datum_2'];
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'prijemnica.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $pri = new Prijemnica();
        $magacini = (new Magacin())->all();
        $dobavljaci = (new Dobavljac())->all();

        // Logovi
        $sql = "SELECT * FROM prijemnice {$where} ORDER BY datum DESC;";
        $prijemnice = $pri->paginate($path, $page, $sql, $params);
        return $this->render($response, 'prijemnice/lista.twig', compact('prijemnice', 'magacini', 'dobavljaci', 'data'));
    }

    public function getPrijemnicaPregled(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $prijemnica = (new Prijemnica())->find($id);
        $artikli = (new Artikal())->all();
        return $this->render($response, 'prijemnice/pregled.twig', compact('prijemnica', 'artikli'));
    }

    public function getPrijemnicaDobavljac(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_dobavljaca = (int) $request->getAttribute('id');
        $prijemnice = [];
        $dob = new Dobavljac();
        $dobaljac = null;
        if ($id_dobavljaca !== 0) {
            $sql = "SELECT * FROM prijemnice WHERE id_dobavljaca = :id_dobavljaca ORDER BY datum DESC;";
            $prijemnice = (new Prijemnica())->fetch($sql, [':id_dobavljaca' => $id_dobavljaca]);
            $dobavljac = $dob->find($id_dobavljaca);
        }
        $dobavljaci = $dob->all();
        return $this->render($response, 'prijemnice/lista_1.twig', compact('prijemnice', 'dobavljaci', 'dobavljac'));
    }

    public function getPrijemnicaMagacin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_magacina = $request->getAttribute('id');
        $prijemnice = [];
        $mag = new Magacin();
        $magacin = null;
        if ($id_magacina !== 0) {
            $sql = "SELECT * FROM prijemnice WHERE id_magacina = :id_magacina ORDER BY datum DESC;";
            $prijemnice = (new Prijemnica())->fetch($sql, [':id_magacina' => $id_magacina]);
            $magacin = $mag->find($id_magacina);
        }
        $magacini = $mag->all();
        return $this->render($response, 'prijemnice/lista_1.twig', compact('prijemnice', 'magacini', 'magacin'));
    }
}
