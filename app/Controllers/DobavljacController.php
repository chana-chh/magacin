<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\Dobavljac;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DobavljacController extends Controller
{

    public function getDobavljacLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['DOBAVLJAC_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $model = new Dobavljac();

        $sql = "SELECT * FROM dobavljaci ORDER BY naziv DESC;";
        $dobavljaci = $model->paginate($path, $page, $sql, [], null, 3);
        return $this->render($response, 'dobavljaci/lista.twig', compact('dobavljaci'));
    }

    public function postDobavljacPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['DOBAVLJAC_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'dobavljac.pretraga.get');
    }

    public function getDobavljacPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['DOBAVLJAC_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['naziv'])) {
            $conditions[] = 'naziv LIKE :naziv';
            $params[':naziv'] = '%' . $data['naziv'] . '%';
        }

        if (!empty($data['pib'])) {
            $conditions[] = 'pib LIKE :pib';
            $params[':pib'] = '%' . $data['pib'] . '%';
        }

        if (!empty($data['racun'])) {
            $conditions[] = 'racun LIKE :racun';
            $params[':racun'] = '%' . $data['racun'] . '%';
        }

        if (!empty($data['adresa_mesto'])) {
            $conditions[] = 'adresa_mesto LIKE :adresa_mesto';
            $params[':adresa_mesto'] = '%' . $data['adresa_mesto'] . '%';
        }

        if (!empty($data['adresa_ulica'])) {
            $conditions[] = 'adresa_ulica LIKE :adresa_ulica';
            $params[':adresa_ulica'] = '%' . $data['adresa_ulica'] . '%';
        }

        if (!empty($data['adresa_broj'])) {
            $conditions[] = 'adresa_broj LIKE :adresa_broj';
            $params[':adresa_broj'] = '%' . $data['adresa_broj'] . '%';
        }

        if (!empty($data['telefon'])) {
            $conditions[] = 'telefon LIKE :telefon';
            $params[':telefon'] = '%' . $data['telefon'] . '%';
        }

        if (!empty($data['email'])) {
            $conditions[] = 'email LIKE :email';
            $params[':email'] = '%' . $data['email'] . '%';
        }

        if (!empty($data['napomena'])) {
            $conditions[] = 'napomena LIKE :napomena';
            $params[':napomena'] = '%' . $data['napomena'] . '%';
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'dobavljac.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $model = new Dobavljac();

        $sql = "SELECT * FROM dobavljaci {$where} ORDER BY naziv DESC;";
        $dobavljaci = $model->paginate($path, $page, $sql, $params, null, 3);
        return $this->render($response, 'dobavljaci/lista.twig', compact('dobavljaci', 'data'));
    }

    public function getDobavljacDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'dobavljaci/dodavanje.twig');
    }

    public function postDobavljacDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'dobavljaci.naziv',
                'maxlen' => 255,
            ],
            'adresa_mesto' => [
                'maxlen' => 50,
            ],
            'pib' => [
                'maxlen' => 50,
            ],
            'racun' => [
                'maxlen' => 50,
            ],
            'adresa_ulica' => [
                'maxlen' => 100,
            ],
            'adresa_broj' => [
                'maxlen' => 30,
            ],
            'telefon' => [
                'maxlen' => 30,
            ],
            'email' => [
                'maxlen' => 60,
                'email' => true,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање добављача');
            return $this->redirect($request, $response, 'dobavljac.lista');
        }

        $objekat = new Dobavljac();
        $id = $objekat->insert($data);
        $model = $objekat->find($id);
        $this->log($this::DODAVANJE, 'Додавање добављача', $model);
        $this->flash('success', 'Успешно додавање добављача');

        return $this->redirect($request, $response, 'dobavljac.lista');
    }

    public function getDobavljacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new Dobavljac();
        $dobavljac = $model->find($id);
        return $this->render($response, 'dobavljaci/izmena.twig', compact('dobavljac'));
    }

    public function postDobavljacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'dobavljaci.naziv#id:'.$id,
                'maxlen' => 255,
                'alnum' => true,
            ],
            'adresa_mesto' => [
                'maxlen' => 50,
            ],
            'pib' => [
                'maxlen' => 50,
            ],
            'racun' => [
                'maxlen' => 50,
            ],
            'adresa_ulica' => [
                'maxlen' => 100,
            ],
            'adresa_broj' => [
                'maxlen' => 30,
            ],
            'telefon' => [
                'maxlen' => 30,
            ],
            'email' => [
                'maxlen' => 30,
                'email' => true,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена добављача');
            return $this->redirect($request, $response, 'dobavljac.izmena.get', ['id' => $id]);
        }

        $this->flash('success', 'Подаци добављача су успешно измењени.');
        $objekat = new Dobavljac();
        $stari = $objekat->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $objekat->update($data, $id);
        $dobavljac = $objekat->find($id);
        $this->log($this::IZMENA, 'Измена добављача', $dobavljac, $stari);
        return $this->redirect($request, $response, 'dobavljac.lista');
    }

    public function postDobavljacBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $objekat = new Dobavljac();
        $model = $objekat->find($id);

        if (count($model->prijemnice())>0) {
            $this->flash('danger', 'Све пријемнице на којима се јавља овај добављач морају бити уклоњене пре брисања добављача');
            return $this->redirect($request, $response, 'dobavljac.lista');
        }

        $ok = $objekat->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање добављача');
            return $this->redirect($request, $response, 'dobavljac.lista');
        }
        
        $this->log($this::BRISANJE, 'Брисање добављача', $model);
        $this->flash('success', 'Успешно брисање добављача');
        return $this->redirect($request, $response, 'dobavljac.lista');
    }
}
