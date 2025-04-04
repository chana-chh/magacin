<?php

namespace App\Models;

use App\Classes\Model;

class Nalog extends Model
{
    protected string $table = 'nalozi';

    public function magaciniz()
    {
        return (new Magacin())->find($this->id_iz_mag);
    }

    public function magacinu()
    {
        return (new Magacin())->find($this->id_u_mag);
    }

    public function stavke()
    {
        return $this->hasMany('App\Models\NalogArtikal', 'id_naloga');
    }

    public function tip()
    {
        return $this->belongsTo('App\Models\TipNaloga', 'id_tipa');
    }
}
