<?php

namespace App\Controllers;

use App\Models\Magacin;
use App\Models\Kupac;
use App\Models\Otpremnica;
use App\Models\Stanje;
use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OtpremnicaController extends Controller
{
    public function getOtpremnicaLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['MAGACIN_OTPREMNICE_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();
        $kupci = (new Kupac())->all();

        $otpr = new Otpremnica();
        $sql = "SELECT * FROM otpremnice ORDER BY datum DESC;";
        $otpremnice = $otpr->paginate($path, $page, $sql, [], null, 3);

        return $this->render($response, 'otpremnice/lista.twig', compact('otpremnice', 'magacini', 'kupci'));
    }

    public function getOtpremnicaDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $magacini = (new Magacin())->all();
        $kupci = (new Kupac())->all();
        return $this->render($response, 'otpremnice/dodavanje.twig', compact('magacini', 'kupci'));
    }

    public function postOtpremnicaDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
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
            'id_kupca' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање отпремнице');
            return $this->redirect($request, $response, 'otpremnica.dodavanje.get');
        }

        $otpr = new Otpremnica();
        $id = $otpr->insert($data);
        $model = $otpr->find($id);
        $this->log($this::DODAVANJE, 'Додавање отпремнице', $model);
        $this->flash('success', 'Успешно додавање отпремнице');

        return $this->redirect($request, $response, 'otpremnica.lista');
    }

    public function getOtpremnicaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $otpremnica = (new Otpremnica())->find($id);
        $magacini = (new Magacin())->all();
        $kupci = (new Kupac())->all();
        return $this->render($response, 'otpremnice/izmena.twig', compact('otpremnica', 'magacini', 'kupci'));
    }

    public function postOtpremnicaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
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
            'id_kupca' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена отпремнице');
            return $this->redirect($request, $response, 'otpremnica.izmena.get', ['id' => $id]);
        }

        $otpr = new Otpremnica();
        $stari = $otpr->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $otpr->update($data, $id);
        $otpremnica = $otpr->find($id);
        $this->log($this::IZMENA, 'Измена отпремнице', $otpremnica, $stari);
        $this->flash('success', 'Успешна измена отпремнице');

        return $this->redirect($request, $response, 'otpremnica.lista');
    }

    public function postOtpremnicaBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $otpr = new Otpremnica();
        $model = $otpr->find($id);
        $ok = $otpr->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање отпремнице');
            return $this->redirect($request, $response, 'otpremnica.lista');
        }

        $this->log($this::BRISANJE, 'Брисање отпремнице', $model);
        $this->flash('success', 'Успешно брисање отпремнице');
        return $this->redirect($request, $response, 'otpremnica.lista');
    }

    public function postOtpremnicaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_OTPREMNICE_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'otpremnica.pretraga.get');
    }

    public function getOtpremnicaPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['MAGACIN_OTPREMNICE_PRETRAGA'] ?? [];
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

        if (!empty($data['id_kupca'])) {
            $conditions[] = 'id_kupca = :id_kupca';
            $params[':id_kupca'] = $data['id_kupca'];
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
            return $this->redirect($request, $response, 'otpremnica.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $otpr = new Otpremnica();
        $magacini = (new Magacin())->all();
        $kupci = (new Kupac())->all();

        // Logovi
        $sql = "SELECT * FROM otpremnice {$where} ORDER BY datum DESC;";
        $otpremnice = $otpr->paginate($path, $page, $sql, $params, null, 3);
        return $this->render($response, 'otpremnice/lista.twig', compact('otpremnice', 'magacini', 'kupci', 'data'));
    }

    public function getOtpremnicaPregled(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $otpremnica = (new Otpremnica())->find($id);
        $artikli = (new Stanje())->stanjeMagacin($otpremnica->id_magacina);
        return $this->render($response, 'otpremnice/pregled.twig', compact('otpremnica', 'artikli'));
    }

    public function getOtpremnicaKupac(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_kupca = (int) $request->getAttribute('id');
        $otpremnice = [];
        $kup = new Kupac();
        $kupac = null;
        if ($id_kupca !== 0) {
            $sql = "SELECT * FROM otpremnice WHERE id_kupca = :id_kupca ORDER BY datum DESC;";
            $otpremnice = (new Otpremnica())->fetch($sql, [':id_kupca' => $id_kupca]);
            $kupac = $kup->find($id_kupca);
        }
        $kupci = $kup->all();
        return $this->render($response, 'otpremnice/lista_1.twig', compact('otpremnice', 'kupci', 'kupac'));
    }

    public function getOtpremnicaMagacin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_magacina = $request->getAttribute('id');
        $otpremnice = [];
        $mag = new Magacin();
        $magacin = null;
        if ($id_magacina !== 0) {
            $sql = "SELECT * FROM otpremnice WHERE id_magacina = :id_magacina ORDER BY datum DESC;";
            $otpremnice = (new Otpremnica())->fetch($sql, [':id_magacina' => $id_magacina]);
            $magacin = $mag->find($id_magacina);
        }
        $magacini = $mag->all();
        return $this->render($response, 'otpremnice/lista_1.twig', compact('otpremnice', 'magacini', 'magacin'));
    }
}
