<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\OtpremnicaArtikal;
use App\Models\Stanje;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OtpremnicaArtikalController extends Controller
{
    public function postOtpremnicaStavkeDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'id_artikla' => [
                'required' => true,
            ],
            'kolicina' => [
                'required' => true,
                'min' => 0,
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање ставке отпремнице');
            return $this->redirect($request, $response, 'otpremnica.pregled', ['id' => $data['id_otpremnice']]);
        }

        $id_magacina = (int) $data['id_magacina'];
        unset($data['id_magacina']);

        // Update kolicine na stanju (pre dodavanja stavke zbog stanja)
        $stanje = new Stanje();
        $stanje->oduzmiKolicinu($id_magacina, (int) $data['id_artikla'], (float) $data['kolicina']);

        $st = new OtpremnicaArtikal();
        $id = $st->insert($data);
        $stavka = $st->find($id);

        $this->log($this::DODAVANJE, 'Додавање ставке отпремнице', $stavka);
        $this->flash('success', 'Успешно додавање ставке отпремнице');

        return $this->redirect($request, $response, 'otpremnica.pregled', ['id' => $data['id_otpremnice']]);
    }

    public function postOtpremnicaStavkeBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $id_magacina = (int) $data['idMagacina'];
        $st = new OtpremnicaArtikal();
        $model = $st->find($id);
        // Update kolicine na stanju (pre brisanja stavke zbog stanja)
        $stanje = new Stanje();
        $stanje->dodajKolicinu($id_magacina, (int) $model->id_artikla, (float) $model->kolicina);

        $ok = $st->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање ставке отпремнице');
            return $this->redirect($request, $response, 'otpremnica.pregled', ['id' => $model->id_otpremnice]);
        }

        $this->log($this::BRISANJE, 'Брисање ставке отпремнице', $model);
        $this->flash('success', 'Успешно брисање ставке отпремнице');
        return $this->redirect($request, $response, 'otpremnica.pregled', ['id' => $model->id_otpremnice]);
    }
}
