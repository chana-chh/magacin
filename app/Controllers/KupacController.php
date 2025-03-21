<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\Kupac;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class KupacController extends Controller
{

    public function getKupacLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new Kupac();
        $data = $model->all();
        return $this->render($response, 'kupci/lista.twig', compact('data'));
    }

    public function postKupacDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'kupci.naziv',
                'maxlen' => 255,
                'alnum' => true,
            ],
            'sediste' => [
                'maxlen' => 255,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање добављача');
            return $this->redirect($request, $response, 'kupac.lista');
        }

        $objekat = new Kupac();
        $id = $objekat->insert($data);
        $model = $objekat->find($id);
        $this->log($this::DODAVANJE, 'Додавање добављача', $model);
        $this->flash('success', 'Успешно додавање добављача');

        return $this->redirect($request, $response, 'kupac.lista');
    }

    public function getKupacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new Kupac();
        $kupac = $model->find($id);
        return $this->render($response, 'kupci/izmena.twig', compact('kupac'));
    }

    public function postKupacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'kupci.naziv#id:' . $id,
                'maxlen' => 255,
                'alnum' => true,
            ],
            'sediste' => [
                'maxlen' => 255,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена добављача');
            return $this->redirect($request, $response, 'kupac.izmena.get', ['id' => $id]);
        }

        $this->flash('success', 'Подаци добављача су успешно измењени.');
        $objekat = new Kupac();
        $stari = $objekat->find($id);

        $objekat->update($data, $id);
        $kupac = $objekat->find($id);
        $this->log($this::IZMENA, 'Измена добављача', $kupac, $stari);
        return $this->redirect($request, $response, 'kupac.lista');
    }

    public function postKupacBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $objekat = new Kupac();
        $model = $objekat->find($id);
        $ok = $objekat->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање добављача');
            return $this->redirect($request, $response, 'kupac.lista');
        }
        
        $this->log($this::BRISANJE, 'Брисање добављача', $model);
        $this->flash('success', 'Успешно брисање добављача');
        return $this->redirect($request, $response, 'kupac.lista');
    }
}
