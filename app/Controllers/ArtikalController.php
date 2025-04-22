<?php

namespace App\Controllers;

use DateTime;
use App\Models\Otpis;
use App\Models\Stavka;
use App\Models\Artikal;
use App\Classes\Controller;
use App\Models\JedinicaMere;
use App\Models\NalogArtikal;
use Slim\Routing\RouteParser;
use Slim\Routing\RouteContext;
use App\Models\KategorijaArtikla;
use App\Models\OtpremnicaArtikal;
use App\Models\PrijemnicaArtikal;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArtikalController extends Controller
{
    public function getArtikalLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        unset($_SESSION['MAGACIN_ARTIKAL_PRETRAGA']);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();

        $art = new Artikal();
        $sql = "SELECT * FROM artikli ORDER BY naziv ASC;";
        $artikli = $art->paginate($path, $page, $sql, []);
        return $this->render($response, 'artikli/lista.twig', compact('artikli', 'kategorije', 'jm'));
    }

    public function getArtikalDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();
        return $this->render($response, 'artikli/dodavanje.twig', compact('kategorije', 'jm'));
    }

    public function postArtikalDodavanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $rules = [
            'id_kategorije' => [
                'required' => true,
            ],
            'naziv' => [
                'required' => true,
                'maxlen' => 255,
                'multi_unique' => 'artikli.id_kategorije,naziv',
            ],
            'id_jm' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешно додавање артикла');
            return $this->redirect($request, $response, 'artikal.dodavanje.get');
        }

        $art = new Artikal();
        $id = $art->insert($data);
        $model = $art->find($id);
        $this->log($this::DODAVANJE, 'Додавање артикла', $model);
        $this->flash('success', 'Успешно додавање артикла');

        return $this->redirect($request, $response, 'artikal.lista');
    }

    public function getArtikalIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $artikal = (new Artikal())->find($id);
        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();
        return $this->render($response, 'artikli/izmena.twig', compact('artikal', 'kategorije', 'jm'));
    }

    public function postArtikalIzmena(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['id'];
        unset($data['id']);
        $rules = [
            'id_kategorije' => [
                'required' => true,
            ],
            'naziv' => [
                'required' => true,
                'maxlen' => 255,
                'multi_unique' => 'artikli.id_kategorije,naziv#id:' . $id,
            ],
            'id_jm' => [
                'required' => true,
            ],
        ];

        $this->validator()->validate($data, $rules);

        if ($this->validator()->hasErrors()) {
            $this->flash('danger', 'Неуспешна измена артикла');
            return $this->redirect($request, $response, 'artikal.izmena.get', ['id' => $id]);
        }

        $art = new Artikal();
        $stari = $art->find($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $art->update($data, $id);
        $artikal = $art->find($id);
        $this->log($this::IZMENA, 'Измена артикла', $artikal, $stari);
        $this->flash('success', 'Успешна измена артикла');

        return $this->redirect($request, $response, 'artikal.lista');
    }

    public function postArtikalBrisanje(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $id = (int) $data['idBrisanje'];
        $art = new Artikal();
        $model = $art->find($id);
        
        if (count($model->artikliNaloga())>0) {
            $this->flash('danger', 'Ови артикли са свих ставки налога у којима се јављају морају бити уклоњени пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        if (count($model->naloziIz())>0) {
            $this->flash('danger', 'Сви налози у којима се јавља овај артикал морају бити уклоњени пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        if (count($model->naloziU())>0) {
            $this->flash('danger', 'Сви налози у којима се јавља овај артикал морају бити уклоњени пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        if (count($model->otpisi())>0) {
            $this->flash('danger', 'Сви отписи у којима се јавља овај артикал морају бити уклоњени пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        if (count($model->artikliOtpremnice())>0) {
            $this->flash('danger', 'Све ставке отпремнице у којима се јавља овај артикал морају бити уклоњене пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        if (count($model->popisArtikli())>0) {
            $this->flash('danger', 'Све ставке пописа у којима се јавља овај артикал морају бити уклоњени пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        if (count($model->artikliPrijemnice())>0) {
            $this->flash('danger', 'Све ставке пријемнице у којима се јавља овај артикал морају бити уклоњене пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }        

        if (count($model->stanje())>0) {
            $this->flash('danger', 'Још увек има артикала на стању морају бити уклоњени пре брисања артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }


        $ok = $art->deleteOne($id);

        if (!$ok) {
            $this->flash('danger', 'Неуспешно брисање артикла');
            return $this->redirect($request, $response, 'artikal.lista');
        }

        $this->log($this::BRISANJE, 'Брисање артикла', $model);
        $this->flash('success', 'Успешно брисање артикла');
        return $this->redirect($request, $response, 'artikal.lista');
    }

    public function getArtikalPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $_SESSION['MAGACIN_ARTIKAL_PRETRAGA'] ?? [];
        $conditions = [];
        $params = [];

        if (!empty($data['id_kategorije'])) {
            $conditions[] = 'id_kategorije = :id_kategorije';
            $params[':id_kategorije'] = $data['id_kategorije'];
        }

        if (!empty($data['naziv'])) {
            $conditions[] = 'naziv LIKE :naziv';
            $params[':naziv'] = '%' . $data['naziv'] . '%';
        }

        if (!empty($data['id_jm'])) {
            $conditions[] = 'id_jm = :id_jm';
            $params[':id_jm'] = $data['id_jm'];
        }

        if (empty($conditions)) {
            return $this->redirect($request, $response, 'artikal.lista');
        }

        $where = "WHERE " . implode(' AND ', $conditions);

        // Paginacija
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;

        $art = new Artikal();
        $kategorije = (new KategorijaArtikla())->all();
        $jm = (new JedinicaMere())->all();

        // Logovi
        $sql = "SELECT * FROM artikli {$where} ORDER BY naziv ASC;";
        $artikli = $art->paginate($path, $page, $sql, $params, null, 3);
        return $this->render($response, 'artikli/lista.twig', compact('artikli', 'kategorije', 'jm', 'data'));
    }

    public function postArtikalPretraga(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->data($request);
        $_SESSION['MAGACIN_ARTIKAL_PRETRAGA'] = $data;
        return $this->redirect($request, $response, 'artikal.pretraga.get');
    }

    public function getArtikalKartica(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        $art = new Artikal();
        $artikal = $art->find($id);
        $artikli = $art->all();

        $stavke = [];
        $kolicina = 0;

        // prijemnice stavke
        $prijemnice_stavke = (new PrijemnicaArtikal())->artikliPrijemnice($id);

        // otpisi stavke
        $otpisi_stavke = (new Otpis())->artikliOtpis($id);

        // otpremnice stavke
        $otpremnice_stavke = (new OtpremnicaArtikal())->artikliOtpremnice($id);

        // nalozi stavke
        $nalozi_stavke = (new NalogArtikal())->artikliNalozi($id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        foreach ($prijemnice_stavke as $stavka) {
            $st = new Stavka();
            $st->vrsta = 'пријемница';
            $st->datum = new DateTime($stavka->prijemnica()->datum);
            $st->izlaz = $stavka->prijemnica()->broj . ' / ' . $stavka->prijemnica()->dobavljac()->naziv;
            $st->izlaz_ruta = $routeParser->urlFor('prijemnica.pregled.no', ['id' => $stavka->prijemnica()->id]);
            $st->ulaz = $stavka->prijemnica()->broj . ' / ' . $stavka->prijemnica()->magacin()->naziv;
            $st->ulaz_ruta = $routeParser->urlFor('prijemnica.magacin', ['id' => $stavka->prijemnica()->magacin()->id]);
            $st->kolicina = $stavka->kolicina;
            $st->ui = 1;
            $st->iznos = $stavka->iznos;
            $st->placeno = $stavka->placeno;
            $st->stanje = 0;
            $stavke[] = $st;
            $kolicina += $stavka->kolicina;
        }

        foreach ($otpisi_stavke as $stavka) {
            $st = new Stavka();
            $st->vrsta = 'отпис';
            $st->datum = new DateTime($stavka->datum);
            $st->izlaz = $stavka->artikal()->naziv;
            $st->izlaz_ruta = $routeParser->urlFor('otpis.artikal', ['id' => $stavka->id_artikla]);
            $st->ulaz = '';
            $st->ulaz_ruta = '';
            $st->kolicina = $stavka->kolicina;
            $st->ui = 0;
            $st->iznos = 0;
            $st->placeno = 0;
            $st->stanje = 0;
            $stavke[] = $st;
            $kolicina -= $stavka->kolicina;
        }

        foreach ($otpremnice_stavke as $stavka) {
            $st = new Stavka();
            $st->vrsta = 'отпремница';
            $st->datum = new DateTime($stavka->otpremnica()->datum);
            $st->izlaz = $stavka->otpremnica()->broj . ' / ' . $stavka->otpremnica()->magacin()->naziv;
            $st->izlaz_ruta = $routeParser->urlFor('otpremnica.magacin', ['id' => $stavka->otpremnica()->magacin()->id]);
            $st->ulaz = $stavka->otpremnica()->broj . ' / ' . $stavka->otpremnica()->kupac();
            $st->ulaz_ruta = $routeParser->urlFor('otpremnica.pregled.no', ['id' => $stavka->otpremnica()->id]);
            $st->kolicina = $stavka->kolicina;
            $st->ui = 0;
            $st->iznos = $stavka->iznos;
            $st->placeno = $stavka->placeno;
            $st->stanje = 0;
            $stavke[] = $st;
            $kolicina -= $stavka->kolicina;
        }

        foreach ($nalozi_stavke as $stavka) {
            $st = new Stavka();
            $st->vrsta = 'интерни налог';
            $st->datum = new DateTime($stavka->nalog()->datum);
            if ($stavka->smer === 'УЛАЗ') {
                $st->izlaz = '';
                $st->izlaz_ruta = '';
                $st->ulaz = $stavka->nalog()->broj . ' / ' . $stavka->magacin()->naziv;
                $st->ulaz_ruta = $routeParser->urlFor('nalog.magacinu', ['id' => $stavka->magacin()->id]);
                $st->ui = 1;
                $kolicina += $stavka->kolicina;
            } else {
                $st->izlaz = $stavka->nalog()->broj . ' / ' . $stavka->magacin()->naziv;
                $st->izlaz_ruta = $routeParser->urlFor('nalog.magacinu', ['id' => $stavka->magacin()->id]);
                $st->ulaz = '';
                $st->ulaz_ruta = '';
                $st->ui = 0;
                $kolicina -= $stavka->kolicina;
            }
            $st->kolicina = $stavka->kolicina;
            $st->iznos = 0;
            $st->placeno = 0;
            $st->stanje = 0;
            $stavke[] = $st;
        }

        usort($stavke, function ($a, $b) {
            return $a->datum <=> $b->datum;
        });

        $stanje = 0;
        foreach ($stavke as $stavka) {
            if ($stavka->ui == 1) {
                $stanje += $stavka->kolicina;
            } else {
                $stanje -= $stavka->kolicina;
            }
            $stavka->stanje = $stanje;
        }

        return $this->render($response, 'artikli/kartica.twig', compact('artikal', 'artikli', 'stavke', 'kolicina'));
    }
}
