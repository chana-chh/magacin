<?php

namespace App\Models;

use App\Classes\Model;

class NalogArtikal extends Model
{
    protected string $table = 'nalog_artikal';

    public function nalog()
    {
        return $this->belongsTo('App\Models\Nalog', 'id_naloga');
    }

    public function artikaliz()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla_iz');
    }

    public function artikalu()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla_u');
    }
}