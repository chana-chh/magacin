<?php

namespace App\Controllers;

use App\Models\Otpis;
use App\Models\Stanje;
use App\Models\Artikal;
use App\Models\Magacin;
use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OtpisController extends Controller
{
    public function getOtpisLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['MAGACIN_OTPIS_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();
        $artikli = (new Artikal())->all();

        $otp = new Otpis();
        $sql = "SELECT * FROM otpisi ORDER BY datum DESC;";
        $otpisi = $otp->paginate($path, $page, $sql, []);
        return $this->render($response, 'otpisi/lista.twig', compact('otpisi', 'magacini', 'artikli'));
    }

    public function postOtpisDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'datum' => [
                'required' => true,
            ],
            'id_magacina' => [
                'required' => true,
            ],
            'id_artikla' => [
                'required' => true,
            ],
            'kolicina' => [
                'min' => 0,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање отписа');
            return $this->redirect($request, $response, 'otpis.lista');
        }

        $stanje = new Stanje();
        $stanje->oduzmiKolicinu((int) $data['id_magacina'], (int) $data['id_artikla'], (float) $data['kolicina']);

        $otp = new Otpis();
        $id = $otp->insert($data);
        $model = $otp->find($id);
        $this->log($this::DODAVANJE, 'Додавање отписа', $model);
        $this->flash('success', 'Успешно додавање отписа');

        return $this->redirect($request, $response, 'otpis.lista');
    }

    public function postOtpisBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $otp = new Otpis();
        $otpis = $otp->find($id);

        $stanje = new Stanje();
        $stanje->dodajKolicinu((int) $otpis->id_magacina, (int) $otpis->id_artikla, (float) $otpis->kolicina);

        $ok = $otp->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање отписа');
            return $this->redirect($request, $response, 'otpis.lista');
        }

        $this->log($this::BRISANJE, 'Брисање отписа', $otpis);
        $this->flash('success', 'Успешно брисање отписа');
        return $this->redirect($request, $response, 'otpis.lista');
    }

    public function postOtpisPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_OTPIS_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'otpis.pretraga.get');
    }

    public function getOtpisPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['MAGACIN_OTPIS_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['id_magacina'])) {
            $conditions[] = 'id_magacina = :id_magacina';
            $params[':id_magacina'] = $data['id_magacina'];
        }

        if (!empty($data['id_artikla'])) {
            $conditions[] = 'id_artikla = :id_artikla';
            $params[':id_artikla'] = $data['id_artikla'];
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
        $artikli = (new Artikal())->all();

        $otp = new Otpis();
        $sql = "SELECT * FROM otpisi {$where} ORDER BY datum DESC;";
        $otpisi = $otp->paginate($path, $page, $sql, $params);
        return $this->render($response, 'otpisi/lista.twig', compact('otpisi', 'magacini', 'artikli', 'data'));
    }
}
