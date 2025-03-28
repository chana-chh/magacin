<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\TipMagacina;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TipMagacinaController extends Controller
{
    public function getTipMagacinaLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $tip = new TipMagacina();
        $tipovi = $tip->all();

        return $this->render($response, 'tipovi_magacina/lista.twig', compact('tipovi'));
    }

    public function postTipMagacinaDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'naziv' => [
                'required' => true,
                'maxlen' => 100,
                'alnum' => true,
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање јединице мере');
            return $this->redirect($request, $response, 'tip.magacina.lista');
        }

        $tip = new TipMagacina();
        $id = $tip->insert($data);
        $model = $tip->find($id);
        $this->log($this::DODAVANJE, 'Додавање типа магацина', $model);
        $this->flash('success', 'Успешно додавање типа магацина');

        return $this->redirect($request, $response, 'tip.magacina.lista');
    }

    public function getTipMagacinaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new TipMagacina();
        $tip = $model->find($id);
        return $this->render($response, 'tipovi_magacina/izmena.twig', compact('tip'));
    }

    public function postTipMagacinaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'naziv' => [
                'required' => true,
                'maxlen' => 100,
                'alnum' => true,
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена типа магацина');
            return $this->redirect($request, $response, 'tip.magacina.izmena.get', ['id' => $id]);
        }

        $this->flash('success', 'Подаци типа магацина су успешно измењени.');
        $tip = new TipMagacina();
        $stari = $tip->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $tip->update($data, $id);
        $tip_mag = $tip->find($id);
        $this->log($this::IZMENA, 'Измена типа магацина', $tip_mag, $stari);
        return $this->redirect($request, $response, 'tip.magacina.lista');
    }

    public function postTipMagacinaBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $tip = new TipMagacina();
        $model = $tip->find($id);
        $ok = $tip->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање типа магацина');
            return $this->redirect($request, $response, 'tip.magacina.lista');
        }

        $this->log($this::BRISANJE, 'Брисање типа магацина', $model);
        $this->flash('success', 'Успешно брисање типа магацина');
        return $this->redirect($request, $response, 'tip.magacina.lista');
    }
}
