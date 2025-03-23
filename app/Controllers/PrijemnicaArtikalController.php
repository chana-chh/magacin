<?php

namespace App\Controllers;

use App\Models\Artikal;
use App\Models\Magacin;
use App\Models\Dobavljac;
use App\Models\Prijemnica;
use App\Classes\Controller;
use App\Models\PrijemnicaArtikal;
use App\Models\Stanje;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PrijemnicaArtikalController extends Controller
{
    public function postPrijemnicaStavkeDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
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
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање ставке пријемнице');
            return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $data['id_prijemnice']]);
        }

        $id_magacina = (int) $data['id_magacina'];
        unset($data['id_magacina']);

        $st = new PrijemnicaArtikal();
        $id = $st->insert($data);
        $stavka = $st->find($id);
        // Update kolicine na stanju
        $stanje = new Stanje();
        $stanje->dodajKolicinu($id_magacina, (int) $data['id_artikla'], (float) $data['kolicina']);

        $this->log($this::DODAVANJE, 'Додавање ставке пријемнице', $stavka);
        $this->flash('success', 'Успешно додавање ставке пријемнице');

        return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $data['id_prijemnice']]);
    }

    public function postPrijemnicaStavkeBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $id_magacina = (int) $data['idMagacina'];
        $st = new PrijemnicaArtikal();
        $model = $st->find($id);
        $ok = $st->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање ставке пријемнице');
            return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $model->id_prijemnice]);
        }

        // Update kolicine na stanju
        $stanje = new Stanje();
        $stanje->oduzmiKolicinu($id_magacina, (int) $model->id_artikla, (float) $model->kolicina);

        $this->log($this::BRISANJE, 'Брисање ставке пријемнице', $model);
        $this->flash('success', 'Успешно брисање ставке пријемнице');
        return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $model->id_prijemnice]);
    }
}
