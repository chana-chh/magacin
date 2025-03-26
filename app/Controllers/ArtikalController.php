<?php

namespace App\Controllers;

use App\Models\Artikal;
use App\Classes\Controller;
use App\Models\JedinicaMere;
use App\Models\KategorijaArtikla;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArtikalController extends Controller
{
    public function getArtikalLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['MAGACIN_ARTIKAL_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();

        $art = new Artikal();
        $sql = "SELECT * FROM artikli ORDER BY naziv ASC;";
        $artikli = $art->paginate($path, $page, $sql, [], null, 3);
        return $this->render($response, 'artikli/lista.twig', compact('artikli', 'kategorije', 'jm'));
    }

    public function getArtikalDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();
        return $this->render($response, 'artikli/dodavanje.twig', compact('kategorije', 'jm'));
    }

    public function postArtikalDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'id_kategorije' => [
                'required' => true,
            ],
            'naziv' => [
                'required' => true,
                'maxlen' => 255,
                'multi_unique' => 'artikli.id_kategorije,naziv',
            ],
            'id_jm' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање артикла');
            return $this->redirect($request, $response, 'artikal.dodavanje.get');
        }

        $art = new Artikal();
        $id = $art->insert($data);
        $model = $art->find($id);
        $this->log($this::DODAVANJE, 'Додавање артикла', $model);
        $this->flash('success', 'Успешно додавање артикла');

        return $this->redirect($request, $response, 'artikal.lista');
    }

    public function getArtikalIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $artikal = (new Artikal())->find($id);
        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();
        return $this->render($response, 'artikli/izmena.twig', compact('artikal', 'kategorije', 'jm'));
    }

    public function postArtikalIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'id_kategorije' => [
                'required' => true,
            ],
            'naziv' => [
                'required' => true,
                'maxlen' => 255,
                'multi_unique' => 'artikli.id_kategorije,naziv#id:' . $id,
            ],
            'id_jm' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена артикла');
            return $this->redirect($request, $response, 'artikal.izmena.get', ['id' => $id]);
        }

        $art = new Artikal();
        $stari = $art->find($id);
        $art->update($data, $id);
        $artikal = $art->find($id);
        $this->log($this::IZMENA, 'Измена артикла', $artikal, $stari);
        $this->flash('success', 'Успешна измена артикла');

        return $this->redirect($request, $response, 'artikal.lista');
    }

    public function postArtikalBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $art = new Artikal();
        $model = $art->find($id);
        $ok = $art->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        $this->log($this::BRISANJE, 'Брисање артикла', $model);
        $this->flash('success', 'Успешно брисање артикла');
        return $this->redirect($request, $response, 'artikal.lista');
    }

    public function getArtikalPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['MAGACIN_ARTIKAL_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['id_kategorije'])) {
            $conditions[] = 'id_kategorije = :id_kategorije';
            $params[':id_kategorije'] = $data['id_kategorije'];
        }

        if (!empty($data['naziv'])) {
            $conditions[] = 'naziv LIKE :naziv';
            $params[':naziv'] = '%' . $data['naziv'] . '%';
        }

        if (!empty($data['id_jm'])) {
            $conditions[] = 'id_jm = :id_jm';
            $params[':id_jm'] = $data['id_jm'];
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'artikal.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $art = new Artikal();
        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();

        // Logovi
        $sql = "SELECT * FROM artikli {$where} ORDER BY naziv ASC;";
        $artikli = $art->paginate($path, $page, $sql, $params, null, 3);
        return $this->render($response, 'artikli/lista.twig', compact('artikli', 'kategorije', 'jm', 'data'));
    }

    public function postArtikalPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_ARTIKAL_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'artikal.pretraga.get');
    }
}
