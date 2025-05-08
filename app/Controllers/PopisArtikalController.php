<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\Popis;
use App\Models\PopisArtikal;
use App\Models\Stanje;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PopisArtikalController extends Controller
{
    public function postPopisStavkeDodavanje(ServerRequestInterface $request, ResponseInterface $response)
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
            $this->flash('danger', 'Неуспешно додавање ставке пописа');
            return $this->redirect($request, $response, 'popis.pregled', ['id' => $data['id_popisa']]);
        }

        $id_magacina = (int) $data['id_magacina'];
        unset($data['id_magacina']);

        $stanje = new Stanje();
        $stanje_artikla = $stanje->stanjeMagacinArtikal($id_magacina, (int) $data['id_artikla']);
        $data['stanje'] = $stanje_artikla ? $stanje_artikla->kolicina : 0;
        $st = new PopisArtikal();
        $id = $st->insert($data);
        $stavka = $st->find($id);

        $this->log($this::DODAVANJE, 'Додавање ставке пописа', $stavka);
        $this->flash('success', 'Успешно додавање ставке пописа');

        return $this->redirect($request, $response, 'popis.pregled', ['id' => $data['id_popisa']]);
    }

    public function postPopisStavkeBrisanje(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $st = new PopisArtikal();
        $model = $st->find($id);

        $ok = $st->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање ставке пописа');
            return $this->redirect($request, $response, 'popis.pregled', ['id' => $model->id_popisa]);
        }

        $this->log($this::BRISANJE, 'Брисање ставке пописа', $model);
        $this->flash('success', 'Успешно брисање ставке пописа');
        return $this->redirect($request, $response, 'popis.pregled', ['id' => $model->id_popisa]);
    }
}
