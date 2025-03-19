<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\JedinicaMere;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JediniceMereController extends Controller
{

    public function getJedinicaMereLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new JedinicaMere();
        $data = $model->all();
        return $this->render($response, 'jedinice_mere/lista.twig', compact('data'));
    }

    public function postJedinicaMereDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'jm' => [
                'required' => true,
                'alnum' => true,
                'maxlen' => 10,
                'unique' => 'jedinice_mere.jm',
            ],
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
            return $this->redirect($request, $response, 'jedinica.mere.lista');
        }

        $jm = new JedinicaMere();
        $id = $jm->insert($data);
        $model = $jm->find($id);
        $this->log($this::DODAVANJE, 'Додавање јединице мере', $model);
        $this->flash('success', 'Успешно додавање јединице мере');

        return $this->redirect($request, $response, 'jedinica.mere.lista');
    }

    public function getJedinicaMereIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        dd($id);
        return $this->render($response, 'jedinice_mere/izmena.twig');
    }

    public function postJedinicaMereIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        dd('postJedinicaMereIzmena');
        return $this->redirect($request, $response, 'jedinica.mere.lista');
    }

    public function postJedinicaMereBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $jm = new JedinicaMere();
        $model = $jm->find($id);
        $ok = $jm->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање јединице мере');
            return $this->redirect($request, $response, 'jedinica.mere.lista');
        }
        $this->log($this::BRISANJE, 'Брисање јединице мере', $model);
        $this->flash('success', 'Успешно брисање јединице мере');
        return $this->redirect($request, $response, 'jedinica.mere.lista');
    }
}
