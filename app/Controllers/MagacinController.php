<?php

namespace App\Controllers;

use App\Models\Magacin;
use App\Classes\Controller;
use App\Models\TipMagacina;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MagacinController extends Controller
{
    public function getMagacinLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $mag = new Magacin();
        $magacini = $mag->all();

        return $this->render($response, 'magacini/lista.twig', compact('magacini'));
    }

    public function getMagacinDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $tipovi = (new TipMagacina())->all();
        return $this->render($response, 'magacini/dodavanje.twig', compact('tipovi'));
    }

    public function postMagacinDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'id_tipa' => [
                'required' => true,
            ],
            'naziv' => [
                'required' => true,
                'maxlen' => 100,
            ],
            'adresa' => [
                'required' => true,
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање магацина');
            return $this->redirect($request, $response, 'magacin.dodavanje.get');
        }

        $mag = new Magacin();
        $id = $mag->insert($data);
        $model = $mag->find($id);
        $this->log($this::DODAVANJE, 'Додавање магацина', $model);
        $this->flash('success', 'Успешно додавање магацина');

        return $this->redirect($request, $response, 'magacin.lista');
    }

    public function getMagacinIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $magacin = (new Magacin())->find($id);
        $tipovi = (new TipMagacina())->all();
        return $this->render($response, 'magacini/izmena.twig', compact('magacin', 'tipovi'));
    }

    public function postMagacinIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'id_tipa' => [
                'required' => true,
            ],
            'naziv' => [
                'required' => true,
                'maxlen' => 100,
            ],
            'adresa' => [
                'required' => true,
                'maxlen' => 255,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена магацина');
            return $this->redirect($request, $response, 'magacin.izmena.get', ['id' => $id]);
        }

        $mag = new Magacin();
        $stari = $mag->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $mag->update($data, $id);
        $magacin = $mag->find($id);
        $this->log($this::IZMENA, 'Измена магацина', $magacin, $stari);
        $this->flash('success', 'Успешна измена магацина');

        return $this->redirect($request, $response, 'magacin.lista');
    }

    public function postMagacinBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $mag = new Magacin();
        $model = $mag->find($id);

        if (count($model->artikliNaloga())>0) {
            $this->flash('danger', 'Сви артикли налога који се налазе у овом магацину морају бити уклоњени пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        if (count($model->naloziIz())>0) {
            $this->flash('danger', 'Сви налози из овог магацина морају бити уклоњени пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        if (count($model->naloziU())>0) {
            $this->flash('danger', 'Сви налози у овај магацина морају бити уклоњени пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        if (count($model->otpisi())>0) {
            $this->flash('danger', 'Сви отписи везани за овај магацин морају бити уклоњени пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        if (count($model->otpremnice())>0) {
            $this->flash('danger', 'Све отпремнице везане за овај магацин морају бити уклоњене пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        if (count($model->popisi())>0) {
            $this->flash('danger', 'Сви пописи оваг магацина морају бити уклоњени пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        if (count($model->prijemnice())>0) {
            $this->flash('danger', 'Сви пријемнице везане за овај магацин морају бити уклоњене пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }        

        if (count($model->stanje())>0) {
            $this->flash('danger', 'Још увек има артикала на стању магацина морају бити уклоњени пре брисања магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        $ok = $mag->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање магацина');
            return $this->redirect($request, $response, 'magacin.lista');
        }

        $this->log($this::BRISANJE, 'Брисање магацина', $model);
        $this->flash('success', 'Успешно брисање магацина');
        return $this->redirect($request, $response, 'magacin.lista');
    }
}
