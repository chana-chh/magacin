<?php

namespace App\Controllers;

use App\Models\Artikal;
use App\Models\Magacin;
use App\Models\Nalog;
use App\Models\Stanje;
use App\Models\TipNaloga;
use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NalogController extends Controller
{
    public function getNalogLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['NALOZI_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $magacini = (new Magacin())->all();
        $tipovi = (new TipNaloga())->all();
        $nalo = new Nalog();
        $sql = "SELECT * FROM nalozi ORDER BY datum DESC;";
        $nalozi = $nalo->paginate($path, $page, $sql, []);

        return $this->render($response, 'nalozi/lista.twig', compact('nalozi', 'magacini', 'tipovi'));
    }

    public function getNalogDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $magacini = (new Magacin())->all();
        $tipovi = (new TipNaloga())->all();
        return $this->render($response, 'nalozi/dodavanje.twig', compact('magacini', 'tipovi'));
    }

    public function postNalogDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'id_iz_mag' => [
                'required' => true,
            ],
            'id_u_mag' => [
                'required' => true,
            ],
            'id_tipa' => [
                'required' => true,
            ],
            'broj' => [
                'required' => true,
                'maxlen' => 100,
            ],
            'datum' => [
                'required' => true,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање налога');
            return $this->redirect($request, $response, 'nalog.dodavanje.get');
        }

        $nalo = new Nalog();
        $id = $nalo->insert($data);
        $model = $nalo->find($id);
        $this->log($this::DODAVANJE, 'Додавање налога', $model);
        $this->flash('success', 'Успешно додавање налога');

        return $this->redirect($request, $response, 'nalog.lista');
    }

    public function getNalogIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $nalog = (new Nalog())->find($id);
        return $this->render($response, 'nalozi/izmena.twig', compact('nalog'));
    }

    public function postNalogIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'broj' => [
                'required' => true,
                'maxlen' => 100,
            ],
            'datum' => [
                'required' => true,
            ]
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена налога');
            return $this->redirect($request, $response, 'nalog.izmena.get', ['id' => $id]);
        }

        $nalo = new Nalog();
        $stari = $nalo->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $nalo->update($data, $id);
        $nalog = $nalo->find($id);
        $this->log($this::IZMENA, 'Измена налога', $nalog, $stari);
        $this->flash('success', 'Успешна измена налога');

        return $this->redirect($request, $response, 'nalog.lista');
    }

    public function postNalogBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $nalo = new Nalog();
        $model = $nalo->find($id);

        if (count($model->stavke())>0) {
            $this->flash('danger', 'Ставке морају бити уклоњене пре брисања налога');
            return $this->redirect($request, $response, 'nalog.lista');
        }

        $ok = $nalo->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање пријемнице');
            return $this->redirect($request, $response, 'nalog.lista');
        }

        $this->log($this::BRISANJE, 'Брисање пријемнице', $model);
        $this->flash('success', 'Успешно брисање пријемнице');
        return $this->redirect($request, $response, 'nalog.lista');
    }

    public function postNalogPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['NALOZI_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'nalog.pretraga.get');
    }

    public function getNalogPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['NALOZI_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['id_iz_mag'])) {
            $conditions[] = 'id_iz_mag = :id_iz_mag';
            $params[':id_iz_mag'] = $data['id_iz_mag'];
        }

        if (!empty($data['id_u_mag'])) {
            $conditions[] = 'id_u_mag = :id_u_mag';
            $params[':id_u_mag'] = $data['id_u_mag'];
        }

        if (!empty($data['broj'])) {
            $conditions[] = 'broj LIKE :broj';
            $params[':broj'] = '%' . $data['broj'] . '%';
        }

        if (!empty($data['datum_1'])) {
            $conditions[] = 'datum >= :datum_od';
            $params[':datum_od'] = $data['datum_1'];
        }

        if (!empty($data['datum_2'])) {
            $conditions[] = 'datum >= :datum_do';
            $params[':datum_do'] = $data['datum_2'];
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'nalog.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $pri = new Nalog();
        $magacini = (new Magacin())->all();

        // Logovi
        $sql = "SELECT * FROM nalozi {$where} ORDER BY datum DESC;";
        $nalozi = $pri->paginate($path, $page, $sql, $params);
        return $this->render($response, 'nalozi/lista.twig', compact('nalozi', 'magacini', 'data'));
    }

    public function getNalogPregled(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $nalog = (new Nalog())->find($id);
        $artikli = (new Stanje())->stanjeMagacin($nalog->id_iz_mag);
        $artiklisvi = (new Artikal())->all();
        $magacini = (new Magacin())->all();
        if ($nalog->tip()->vise_artikala == 0) {
            return $this->render($response, 'nalozi/pregled_jedan.twig', compact('nalog', 'artikli', 'artiklisvi'));
        }else{
            return $this->render($response, 'nalozi/pregled_vise.twig', compact('nalog', 'artikli', 'artiklisvi', 'magacini'));
        };
        
    }

        public function getNalogPregledNo(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $nalog = (new Nalog())->find($id);
        return $this->render($response, 'nalozi/pregled_1.twig', compact('nalog'));
    }

    public function getNalogMagacinIz(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_iz_mag = (int) $request->getAttribute('id');
        $nalozi = [];
        $mag = new Magacin();
        $magacin = null;
        if ($id_iz_mag !== 0) {
            $sql = "SELECT * FROM nalozi WHERE id_iz_mag = :id_iz_mag ORDER BY datum DESC;";
            $nalozi = (new Nalog())->fetch($sql, [':id_iz_mag' => $id_iz_mag]);
            $magacin = $mag->find($id_iz_mag);
        }
        $magaciniiz = $mag->all();
        return $this->render($response, 'nalozi/lista_1.twig', compact('nalozi', 'magaciniiz', 'magacin'));
    }

    public function getNalogMagacinU(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id_u_mag = (int) $request->getAttribute('id');
        $nalozi = [];
        $mag = new Magacin();
        $magacin = null;
        if ($id_u_mag !== 0) {
            $sql = "SELECT * FROM nalozi WHERE id_u_mag = :id_u_mag ORDER BY datum DESC;";
            $nalozi = (new Nalog())->fetch($sql, [':id_u_mag' => $id_u_mag]);
            $magacin = $mag->find($id_u_mag);
        }
        $magaciniu = $mag->all();
        return $this->render($response, 'nalozi/lista_1.twig', compact('nalozi', 'magaciniu', 'magacin'));
    }
}
