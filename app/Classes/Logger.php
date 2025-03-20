<?php

namespace App\Classes;

use App\Models\Korisnik;
use App\Models\Log;

class Logger
{
    public $korisnik_id = 0;
    public $model = null;

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
            $tabela = $model->getTable();
            $podaci .= "[NEW]\n";
            $mod = get_object_vars($model);
            foreach ($mod as $key => $value) {
                $podaci .= $key . " = " . $value . "\n";
            }
        }
        if ($model_stari !== null) {
            $podaci .= "\n[OLD]\n";
            $mod = get_object_vars($model_stari);
            foreach ($mod as $key => $value) {
                $podaci .= $key . " = " . $value . "\n";
            }
        }

        $data = [
            'tip' => $tip,
            'opis' => $opis,
            'tabela' => $tabela,
            'podaci' => $podaci,
            'id_korisnika' => $this->korisnik_id,
        ];

        $this->model->insert($data);
    }
}
