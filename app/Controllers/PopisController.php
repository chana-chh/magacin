<?php

namespace App\Controllers;

use App\Models\Popis;
use App\Models\Artikal;
use App\Models\Magacin;
use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PopisController extends Controller
{
    public function getPopisLista(ServerRequestInterface $request, ResponseInterface $response)
    {
        unset($_SESSION['MAGACIN_POPIS_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();

        $pop = new Popis();
        $sql = "SELECT * FROM popisi ORDER BY datum DESC;";
        $popisi = $pop->paginate($path, $page, $sql, []);
        return $this->render($response, 'popisi/lista.twig', compact('popisi', 'magacini'));
    }

    public function postPopisDodavanje(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $rules = [
            'datum' => [
                'required' => true,
            ],
            'id_magacina' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање јединице мере');
            return $this->redirect($request, $response, 'jedinica.mere.lista');
        }

        $pop = new Popis();
        $id = $pop->insert($data);
        $model = $pop->find($id);
        $this->log($this::DODAVANJE, 'Додавање пописа', $model);
        $this->flash('success', 'Успешно додавање пописа');

        return $this->redirect($request, $response, 'popis.lista');
    }

    public function getPopisIzmena(ServerRequestInterface $request, ResponseInterface $response)
    {
        $id = $request->getAttribute('id');
        $popis = (new Popis())->find($id);
        $magacini = (new Magacin())->all();
        return $this->render($response, 'popisi/izmena.twig', compact('popis', 'magacini'));
    }

    public function postPopisIzmena(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'id_magacina' => [
                'required' => true,
            ],
            'datum' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена пописа');
            return $this->redirect($request, $response, 'popis.izmena.get', ['id' => $id]);
        }

        $pop = new Popis();
        $stari = $pop->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $pop->update($data, $id);
        $popis = $pop->find($id);
        $this->log($this::IZMENA, 'Измена пописа', $popis, $stari);
        $this->flash('success', 'Успешна измена пописа');

        return $this->redirect($request, $response, 'popis.lista');
    }

    public function postPopisPretraga(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_POPIS_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'popis.pretraga.get');
    }

    public function getPopisPretraga(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $_SESSION['MAGACIN_POPIS_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['id_magacina'])) {
            $conditions[] = 'id_magacina = :id_magacina';
            $params[':id_magacina'] = $data['id_magacina'];
        }

        if (!empty($data['datum_1'])) {
            $conditions[] = 'datum >= :datum_od';
            $params[':datum_od'] = $data['datum_1'];
        }

        if (!empty($data['datum_2'])) {
            $conditions[] = 'datum <= :datum_do';
            $params[':datum_do'] = $data['datum_2'];
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'log.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();

        $pop = new Popis();
        $sql = "SELECT * FROM popisi {$where} ORDER BY datum DESC;";
        $popisi = $pop->paginate($path, $page, $sql, $params);
        return $this->render($response, 'popisi/lista.twig', compact('popisi', 'magacini', 'data'));
    }

    public function postPopisBrisanje(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $id = (int)$data['idBrisanje'];
        $pop = new Popis();
        $model = $pop->find($id);
        $ok = $pop->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање пописа');
            return $this->redirect($request, $response, 'popis.lista');
        }

        $this->log($this::BRISANJE, 'Брисање пописа', $model);
        $this->flash('success', 'Успешно брисање пописа');
        return $this->redirect($request, $response, 'popis.lista');
    }

    public function getPopisPregled(ServerRequestInterface $request, ResponseInterface $response)
    {
        $id = $request->getAttribute('id');
        $popis = (new Popis())->find($id);
        $artikli = (new Artikal())->all();
        return $this->render($response, 'popisi/pregled.twig', compact('popis', 'artikli'));
    }

    public function getPopisListaPregled(ServerRequestInterface $request, ResponseInterface $response)
    {
        unset($_SESSION['MAGACIN_POPIS_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();

        $pop = new Popis();
        $sql = "SELECT * FROM popisi ORDER BY datum DESC;";
        $popisi = $pop->paginate($path, $page, $sql, []);
        return $this->render($response, 'popisi/lista_1.twig', compact('popisi', 'magacini'));
    }

    public function getPopisStavkaPregled(ServerRequestInterface $request, ResponseInterface $response)
    {
        $id = $request->getAttribute('id');
        $popis = (new Popis())->find($id);
        return $this->render($response, 'popisi/pregled_1.twig', compact('popis'));
    }

    public function postPopisPregledPretraga(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_POPIS_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'popis.pregled.pretraga.get');
    }

    public function getPopisPregledPretraga(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $_SESSION['MAGACIN_POPIS_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['id_magacina'])) {
            $conditions[] = 'id_magacina = :id_magacina';
            $params[':id_magacina'] = $data['id_magacina'];
        }

        if (!empty($data['datum_1'])) {
            $conditions[] = 'datum >= :datum_od';
            $params[':datum_od'] = $data['datum_1'];
        }

        if (!empty($data['datum_2'])) {
            $conditions[] = 'datum <= :datum_do';
            $params[':datum_do'] = $data['datum_2'];
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'log.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();

        $pop = new Popis();
        $sql = "SELECT * FROM popisi {$where} ORDER BY datum DESC;";
        $popisi = $pop->paginate($path, $page, $sql, $params);
        return $this->render($response, 'popisi/lista_1.twig', compact('popisi', 'magacini', 'data'));
    }

    public function postPopisZakljucavanje(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $id = (int) $data['idZakljucavanje'];
        $pop = new Popis();
        $model = $pop->find($id);
        $zakljucan = (int) $model->zakljucan;
        if ($zakljucan === 1) {
            $zakljucan = 0;
        } else {
            $zakljucan = 1;
        }
        $ok = $pop->update(['zakljucan' => $zakljucan], $id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно закључавање/откључавање пописа');
            return $this->redirect($request, $response, 'popis.lista');
        }

        $this->log($this::IZMENA, 'Закључавање/откључавање пописа', $model);
        $this->flash('success', 'Успешно закључавање/откључавање пописа');
        return $this->redirect($request, $response, 'popis.lista');
    }
}
