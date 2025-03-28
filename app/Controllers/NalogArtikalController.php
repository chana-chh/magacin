<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\NalogArtikal;
use App\Models\Stanje;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NalogArtikalController extends Controller
{
    public function postNalogStavkeDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'id_artikla_iz' => [
                'required' => true,
            ],
            'id_artikla_u' => [
                'required' => true,
            ],
            'kolicina_iz' => [
                'required' => true,
                'min' => 0,
            ],
            'kolicina_u' => [
                'required' => true,
                'min' => 0,
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање ставке налога');
            return $this->redirect($request, $response, 'nalog.pregled', ['id' => $data['id_naloga']]);
        }

        $id_iz_mag = (int) $data['id_iz_mag'];
        unset($data['id_iz_mag']);

        $id_u_mag = (int) $data['id_u_mag'];
        unset($data['id_u_mag']);

        $stanje = new Stanje();
        $stanje->oduzmiKolicinu($id_iz_mag, (int) $data['id_artikla_iz'], (float) $data['kolicina_iz']);
        $stanje->dodajKolicinu($id_u_mag, (int) $data['id_artikla_u'], (float) $data['kolicina_u']);

        $st = new NalogArtikal();
        $id = $st->insert($data);
        $stavka = $st->find($id);

        $this->log($this::DODAVANJE, 'Додавање ставке налога', $stavka);
        $this->flash('success', 'Успешно додавање ставке налога');

        return $this->redirect($request, $response, 'nalog.pregled', ['id' => $data['id_naloga']]);
    }
}
