<?php

namespace App\Controllers;

use App\Classes\Controller;
use App\Models\KategorijaArtikla;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class KategorijeArtikalaController extends Controller
{
    public function getKategorijaArtiklaLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $kat = new KategorijaArtikla();
        $kategorije = $kat->all();

        return $this->render($response, 'kategorije_artikala/lista.twig', compact('kategorije'));
    }

    public function postKategorijaArtiklaDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
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
            $this->flash('danger', 'Неуспешно додавање категорије артикла');
            return $this->redirect($request, $response, 'kategorija.artikla.lista');
        }

        $kat = new KategorijaArtikla();
        $id = $kat->insert($data);
        $model = $kat->find($id);
        $this->log($this::DODAVANJE, 'Додавање категорије артикла', $model);
        $this->flash('success', 'Успешно додавање категорије артикла');

        return $this->redirect($request, $response, 'kategorija.artikla.lista');
    }

    public function getKategorijaArtiklaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $model = new KategorijaArtikla();
        $kategorija = $model->find($id);
        return $this->render($response, 'kategorije_artikala/izmena.twig', compact('kategorija'));
    }

    public function postKategorijaArtiklaIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
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
            $this->flash('danger', 'Неуспешна измена категорије артикла');
            return $this->redirect($request, $response, 'kategorija.artikla.izmena.get', ['id' => $id]);
        }

        $this->flash('success', 'Подаци категорије артикла су успешно измењени.');
        $kat = new KategorijaArtikla();
        $stari = $kat->find($id);

        $kat->update($data, $id);
        $kat_artikla = $kat->find($id);
        $this->log($this::IZMENA, 'Измена категорије артикла', $kat_artikla, $stari);
        return $this->redirect($request, $response, 'kategorija.artikla.lista');
    }

    public function postKategorijaArtiklaBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $kat = new KategorijaArtikla();
        $model = $kat->find($id);
        $ok = $kat->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање категорије артикла');
            return $this->redirect($request, $response, 'kategorija.artikla.lista');
        }

        $this->log($this::BRISANJE, 'Брисање категорије артикла', $model);
        $this->flash('success', 'Успешно брисање категорије артикла');
        return $this->redirect($request, $response, 'kategorija.artikla.lista');
    }
}
