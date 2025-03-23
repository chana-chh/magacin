<?php

namespace App\Models;

use App\Classes\Model;

class PrijemnicaArtikal extends Model
{
    protected string $table = 'prijemnica_artikal';

    public function prijemnica()
    {
        return $this->belongsTo('App\Models\Prijemnica', 'id_prijemnice');
    }

    public function artikal()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla');
    }
}