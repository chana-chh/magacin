<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\NalogArtikal;
use App\Models\Stanje;
use App\Models\Nalog;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NalogArtikalController extends Controller
{
    public function postNalogStavkeDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = $data['id_naloga'];
        $rules = [
            'id_naloga' => [
                'required' => true,
            ],
            'id_artikla' => [
                'required' => true,
            ],
            'id_magacina' => [
                'required' => true,
            ],
            'kolicina' => [
                'required' => true,
                'min' => 0,
            ],
            'smer' => [
                'required' => true
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање ставке налога');
            return $this->redirect($request, $response, 'nalog.pregled', ['id' => $id]);
        }

        $up = [];
        $id_mag = (int) $data['id_magacina'];

        $nalo = new Nalog();
        $stari = $nalo->find($id);
        $stanje = new Stanje();
        if ($data['smer'] == 1) {
            $stanje->dodajKolicinu($id_mag, (int) $data['id_artikla'], (float) $data['kolicina']);
            $magacin_u = (string) $data['id_magacina'];
            $artikli_u = (string) $data['id_artikla'];
            if (!empty($stari->magacin_u)) {
                $up['magacin_u'] = $stari->magacin_u.','.$magacin_u;
            } else {
                $up['magacin_u'] = $magacin_u;
            }

            if (!empty($stari->artikli_u)) {
                $up['artikli_u'] = $stari->artikli_u.','.$artikli_u;
            } else {
                $up['artikli_u'] = $artikli_u;
            }
        } else {
            $stanje->oduzmiKolicinu($id_mag, (int) $data['id_artikla'], (float) $data['kolicina']);
            $magacin_iz = (string) $data['id_magacina'];
            $artikli_iz = (string) $data['id_artikla'];
            if (!empty($stari->magacin_iz)) {
                $up['magacin_iz'] = $stari->magacin_iz.','.$magacin_iz;
            } else {
                $up['magacin_iz'] = $magacin_iz;
            }

            if (!empty($stari->artikli_iz)) {
                $up['artikli_iz'] = $stari->artikli_iz.','.$artikli_iz;
            } else {
                $up['artikli_iz'] = $artikli_iz;
            }
        }

        $st = new NalogArtikal();
        $ids = $st->insert($data);
        $stavka = $st->find($ids);

        $up['updated_at'] = date('Y-m-d H:i:s');
        $nalo->update($up, $id);

        $this->log($this::DODAVANJE, 'Додавање ставке налога', $stavka);
        $this->flash('success', 'Успешно додавање ставке налога');

        return $this->redirect($request, $response, 'nalog.pregled', ['id' => $id]);
    }

    public function postNalogStavkeBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];

        $stanje = new Stanje();
        $st = new NalogArtikal();
        $model = $st->find($id);
        $nalog_model = new Nalog();
        $nalog = $nalog_model->find($model->id_naloga);

        // Update kolicine na stanju (pre brisanja stavke zbog stanja)
        if ($model->smer == 'УЛАЗ') {
            $stanje->oduzmiKolicinu((int) $model->id_magacina, (int) $model->id_artikla, (float) $model->kolicina);
            $magacin_u = (string) $model->id_magacina;
            $artikli_u = (string) $model->id_artikla;
            $niz_magacin_u = explode(',', $nalog->magacin_u);
            $niz_artikli_u = explode(',', $nalog->artikli_u);
            $indexm = array_search($magacin_u, $niz_magacin_u);
            $indexa = array_search($artikli_u, $niz_artikli_u);
            if ($indexm !== false) {
                array_splice($niz_magacin_u, $indexm, 1);
            };
            if ($indexa !== false) {
                array_splice($niz_artikli_u, $indexa, 1);
            };
            $up['magacin_u'] = implode(',', $niz_magacin_u);
            $up['artikli_u'] = implode(',', $niz_artikli_u);
            $nalog_model->update($up, $model->id_naloga);
        } else {
            $stanje->dodajKolicinu((int) $model->id_magacina, (int) $model->id_artikla, (float) $model->kolicina);
            $magacin_iz = (string) $model->id_magacina;
            $artikli_iz = (string) $model->id_artikla;
            $niz_magacin_iz = explode(',', $nalog->magacin_iz);
            $niz_artikli_iz = explode(',', $nalog->artikli_iz);
            $indexm = array_search($magacin_iz, $niz_magacin_iz);
            $indexa = array_search($artikli_iz, $niz_artikli_iz);
            if ($indexm !== false) {
                array_splice($niz_magacin_iz, $indexm, 1);
            };
            if ($indexa !== false) {
                array_splice($niz_artikli_iz, $indexa, 1);
            };
            $up['magacin_iz'] = implode(',', $niz_magacin_iz);
            $up['artikli_iz'] = implode(',', $niz_artikli_iz);
            $nalog_model->update($up, $model->id_naloga);
        }

        $ok = $st->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање ставке отпремнице');
            return $this->redirect($request, $response, 'nalog.pregled', ['id' => $model->id_naloga]);
        }

        $this->log($this::BRISANJE, 'Брисање ставке отпремнице', $model);
        $this->flash('success', 'Успешно брисање ставке отпремнице');
        return $this->redirect($request, $response, 'nalog.pregled', ['id' => $model->id_naloga]);
    }
}
