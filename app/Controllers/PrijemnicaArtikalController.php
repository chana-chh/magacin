<?php

namespace App\Controllers;

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
        // $placeno = $data['placeno'] ? 1 : 0;
        // $data['placeno'] = $placeno;
        $rules = [
            'id_artikla' => [
                'required' => true,
            ],
            'kolicina' => [
                'required' => true,
                'min' => 0,
            ],
            'cena' => [
                'required' => true,
                'min' => 0,
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање ставке пријемнице');
            return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $data['id_prijemnice']]);
        }

        $id_magacina = (int) $data['id_magacina'];
        unset($data['id_magacina']);

        // Update kolicine na stanju (pre dodavanja stavke zbog stanja)
        $stanje = new Stanje();
        $stanje->dodajKolicinu($id_magacina, (int) $data['id_artikla'], (float) $data['kolicina']);

        $st = new PrijemnicaArtikal();
        // $data['iznos'] = (float) $data['kolicina'] * (float) $data['cena'];
        $data['iznos'] = 0;
        $id = $st->insert($data);
        $stavka = $st->find($id);

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
        // Update kolicine na stanju (pre brisanja stavke zbog stanja)
        $stanje = new Stanje();
        $stanje->oduzmiKolicinu($id_magacina, (int) $model->id_artikla, (float) $model->kolicina);

        $ok = $st->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање ставке пријемнице');
            return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $model->id_prijemnice]);
        }

        $this->log($this::BRISANJE, 'Брисање ставке пријемнице', $model);
        $this->flash('success', 'Успешно брисање ставке пријемнице');
        return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $model->id_prijemnice]);
    }

    public function postPrijemnicaStavkePlacanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idPlacanje'];
        $iznos = (float) $data['iznosPlacanje'];
        $sta = new PrijemnicaArtikal();
        $stavka = $sta->find($id);
        $ok = $sta->update(['iznos' => $iznos], $id);
        $model = $sta->find($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешна промена плаћања');
            return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $stavka->id_prijemnice]);
        }

        $this->log($this::IZMENA, 'Промена плаћања', $model);
        $this->flash('success', 'Успешна промена плаћања');
        return $this->redirect($request, $response, 'prijemnica.pregled', ['id' => $stavka->id_prijemnice]);
    }
}
