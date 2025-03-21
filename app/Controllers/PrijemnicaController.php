<?php

namespace App\Controllers;

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
        $prijemnice = $pri->paginate($path, $page, $sql, [], 2, 3);

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

    public function postPrijemnicaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {}

    public function getPrijemnicaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {}
}
