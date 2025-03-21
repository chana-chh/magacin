<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\Dobavljac;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DobavljacController extends Controller
{

    public function getDobavljacLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new Dobavljac();
        $data = $model->all();
        return $this->render($response, 'dobavljaci/lista.twig', compact('data'));
    }

    public function postDobavljacDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'dobavljaci.naziv',
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
            return $this->redirect($request, $response, 'dobavljac.lista');
        }

        $objekat = new Dobavljac();
        $id = $objekat->insert($data);
        $model = $objekat->find($id);
        $this->log($this::DODAVANJE, 'Додавање добављача', $model);
        $this->flash('success', 'Успешно додавање добављача');

        return $this->redirect($request, $response, 'dobavljac.lista');
    }

    public function getDobavljacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new Dobavljac();
        $dobavljac = $model->find($id);
        return $this->render($response, 'dobavljaci/izmena.twig', compact('dobavljac'));
    }

    public function postDobavljacIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'naziv' => [
                'required' => true,
                'unique' => 'dobavljaci.naziv#id:' . $id,
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
            return $this->redirect($request, $response, 'dobavljac.izmena.get', ['id' => $id]);
        }

        $this->flash('success', 'Подаци добављача су успешно измењени.');
        $objekat = new Dobavljac();
        $stari = $objekat->find($id);

        $objekat->update($data, $id);
        $dobavljac = $objekat->find($id);
        $this->log($this::IZMENA, 'Измена добављача', $dobavljac, $stari);
        return $this->redirect($request, $response, 'dobavljac.lista');
    }

    public function postDobavljacBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $objekat = new Dobavljac();
        $model = $objekat->find($id);
        $ok = $objekat->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање добављача');
            return $this->redirect($request, $response, 'dobavljac.lista');
        }
        
        $this->log($this::BRISANJE, 'Брисање добављача', $model);
        $this->flash('success', 'Успешно брисање добављача');
        return $this->redirect($request, $response, 'dobavljac.lista');
    }
}
