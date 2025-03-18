<?php

namespace App\Classes;

use App\Models\Log;
use App\Models\Korisnik;

class Logger
{
    private Korisnik $korisnik;
    private Log $model;
    const DODAVANJE = "dodavanje";
    const IZMENA = "izmena";
    const BRISANJE = "brisanje";
    const UPLOAD = "upload";

    public function __construct($korisnik)
    {
        $this->korisnik = $korisnik;
        $this->model = new Log();
    }

    public function log($tip, $opis, $model = null, $model_stari = null)
    {
        $podaci = '';
        if ($model !== null) {
            $podaci .= "[new]\n";
            $podaci .= json_encode($model);
        }
        if ($model_stari !== null) {
            $podaci .= "\n\n[old]\n";
            $podaci .= json_encode($model_stari);
        }

        $data = [
            'tip' => $tip,
            'opis' => $opis,
            'pk' => $model->pk,
            'tabela' => $model->getTable(),
            'podaci' => $podaci,
            'korisnik_id' => $this->korisnik->id,
        ];

        $this->model->insert($data);
    }
}
