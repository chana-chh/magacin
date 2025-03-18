<?php

namespace App\Classes;

use App\Models\Korisnik;
use App\Models\Log;

class Logger
{
    public $korisnik_id = 0;
    public $model = null;
    const DODAVANJE = "dodavanje";
    const IZMENA = "izmena";
    const BRISANJE = "brisanje";
    const UPLOAD = "upload";

    public function __construct($korisnik_id)
    {
        $this->korisnik_id = $korisnik_id;
        $this->model = new Log();
    }

    public function log($tip, $opis, $model = null, $model_stari = null)
    {
        $podaci = '';
        $pk = '';
        $tabela = '';
        if ($model !== null) {
            $podaci .= "[new]\n";
            $podaci .= json_encode($model);
            $pk = $model->id;
            $tabela = $model->getTable();
        }
        if ($model_stari !== null) {
            $podaci .= "\n\n[old]\n";
            $podaci .= json_encode($model_stari);
        }

        $data = [
            'tip' => $tip,
            'opis' => $opis,
            'pk' => $pk,
            'tabela' => $tabela,
            'podaci' => $podaci,
            'korisnik_id' => $this->korisnik_id,
        ];

        $this->model->insert($data);
    }
}
