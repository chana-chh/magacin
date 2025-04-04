<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\TipNaloga;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TipNalogaController extends Controller
{
    public function getTipNalogaLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $tip = new TipNaloga();
        $tipovi = $tip->all();

        return $this->render($response, 'tipovi_naloga/lista.twig', compact('tipovi'));
    }

    public function postTipNalogaDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $data['vise_artikala'] = isset($data['vise_artikala']) ? 1 : 0;
        $rules = [
            'naziv' => [
                'required' => true,
                'maxlen' => 100,
                'alnum' => true,
            ],
            'vise_artikala' => [
                'required' => true
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање типа налога');
            return $this->redirect($request, $response, 'tip.naloga.lista');
        }

        $tip = new TipNaloga();
        $id = $tip->insert($data);
        $model = $tip->find($id);
        $this->log($this::DODAVANJE, 'Додавање типа налога', $model);
        $this->flash('success', 'Успешно додавање типа налога');

        return $this->redirect($request, $response, 'tip.naloga.lista');
    }

    public function getTipNalogaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new TipNaloga();
        $tip = $model->find($id);
        return $this->render($response, 'tipovi_naloga/izmena.twig', compact('tip'));
    }

    public function postTipNalogaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $vise_artikala = isset($data['vise_artikala']) ? 1 : 0;
        $data['vise_artikala'] = $vise_artikala;
        
        $rules = [
            'naziv' => [
                'required' => true,
                'maxlen' => 100,
                'alnum' => true,
            ],
            'vise_artikala' => [
                'required' => true
            ],
            'opis' => [
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена типа налога');
            return $this->redirect($request, $response, 'tip.naloga.izmena.get', ['id' => $id]);
        }

        $this->flash('success', 'Подаци типа налога су успешно измењени.');
        $tip = new TipNaloga();
        $stari = $tip->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $tip->update($data, $id);
        $tip_nal = $tip->find($id);
        $this->log($this::IZMENA, 'Измена типа налога', $tip_nal, $stari);
        return $this->redirect($request, $response, 'tip.naloga.lista');
    }

    public function postTipNalogaBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $tip = new TipNaloga();
        $model = $tip->find($id);
        $ok = $tip->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање типа налога');
            return $this->redirect($request, $response, 'tip.naloga.lista');
        }

        $this->log($this::BRISANJE, 'Брисање типа налога', $model);
        $this->flash('success', 'Успешно брисање типа налога');
        return $this->redirect($request, $response, 'tip.naloga.lista');
    }
}
