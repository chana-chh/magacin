<?php

namespace App\Controllers;

use App\Models\Popis;
use App\Models\Magacin;
use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PopisController extends Controller
{
    public function getPopisLista(ServerRequestInterface $request, ResponseInterface $response)
    {
        unset($_SESSION['MAGACIN_POPIS_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();

        $pop = new Popis();
        $sql = "SELECT * FROM popisi ORDER BY datum DESC;";
        $popisi = $pop->paginate($path, $page, $sql, []);
        return $this->render($response, 'popisi/lista.twig', compact('popisi', 'magacini'));
    }

    public function postPopisDodavanje(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->data($request);
        $rules = [
            'datum' => [
                'required' => true,
            ],
            'id_magacina' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање јединице мере');
            return $this->redirect($request, $response, 'jedinica.mere.lista');
        }

        $pop = new Popis();
        $id = $pop->insert($data);
        $model = $pop->find($id);
        $this->log($this::DODAVANJE, 'Додавање пописа', $model);
        $this->flash('success', 'Успешно додавање пописа');

        return $this->redirect($request, $response, 'popis.lista');
    }
}
