<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\Kupac;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class KupacController extends Controller
{

    public function getKupacLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['KUPAC_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $model = new Kupac();

        $sql = "SELECT * FROM kupci ORDER BY naziv ASC;";
        $kupci = $model->paginate($path, $page, $sql, [], null, 3);
        return $this->render($response, 'kupci/lista.twig', compact('kupci'));
    }

    public function postKupacPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['KUPAC_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'kupac.pretraga.get');
    }

    public function getKupacPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['KUPAC_PRETRAGA'] ?? [];
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
            return $this->redirect($request, $response, 'kupac.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $model = new Kupac();

        $sql = "SELECT * FROM kupci {$where} ORDER BY naziv ASC;";
        $kupci = $model->paginate($path, $page, $sql, $params, null, 3);
        return $this->render($response, 'kupci/lista.twig', compact('kupci', 'data'));
    }

    public function getKupacDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'kupci/dodavanje.twig');
    }

    public function postKupacDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'kupci.naziv',
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
            $this->flash('danger', 'Неуспешно додавање купца');
            return $this->redirect($request, $response, 'kupac.lista');
        }

        $objekat = new Kupac();
        $id = $objekat->insert($data);
        $model = $objekat->find($id);
        $this->log($this::DODAVANJE, 'Додавање купца', $model);
        $this->flash('success', 'Успешно додавање купца');

        return $this->redirect($request, $response, 'kupac.lista');
    }

    public function getKupacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new Kupac();
        $kupac = $model->find($id);
        return $this->render($response, 'kupci/izmena.twig', compact('kupac'));
    }

    public function postKupacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'kupci.naziv#id:'.$id,
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
            $this->flash('danger', 'Неуспешна измена купца');
            return $this->redirect($request, $response, 'kupac.izmena.get', ['id' => $id]);
        }

        $this->flash('success', 'Подаци купца су успешно измењени.');
        $objekat = new Kupac();
        $stari = $objekat->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $objekat->update($data, $id);
        $kupac = $objekat->find($id);
        $this->log($this::IZMENA, 'Измена купца', $kupac, $stari);
        return $this->redirect($request, $response, 'kupac.lista');
    }

    public function postKupacBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $objekat = new Kupac();
        $model = $objekat->find($id);
        $ok = $objekat->deleteOne($id);

        if (count($model->otpremnice())>0) {
            $this->flash('danger', 'Све отпремнице на којима се јавља овај купац морају бити уклоњене пре брисања купца');
            return $this->redirect($request, $response, 'dobavljac.lista');
        }

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање купца');
            return $this->redirect($request, $response, 'kupac.lista');
        }
        
        $this->log($this::BRISANJE, 'Брисање купца', $model);
        $this->flash('success', 'Успешно брисање купца');
        return $this->redirect($request, $response, 'kupac.lista');
    }
}
