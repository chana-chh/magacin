<?php

namespace App\Models;

use App\Classes\Model;

class Magacin extends Model
{
    protected string $table = 'magacini';

    public function tip()
    {
        $tip = (new TipMagacina())->find($this->id_tipa);
        return $tip;
    }

    public function artikliNaloga()
    {
        return $this->hasMany('App\Models\NalogArtikal', 'id_magacina');
    }

    public function naloziIz()
    {
        return $this->hasMany('App\Models\Nalog', 'magacin_iz');
    }

    public function naloziU()
    {
        return $this->hasMany('App\Models\Nalog', 'magacin_u');
    }

    public function otpisi()
    {
        return $this->hasMany('App\Models\Otpis', 'id_magacina');
    }

    public function otpremnice()
    {
        return $this->hasMany('App\Models\Otpremnica', 'id_magacina');
    }

    public function popisi()
    {
        return $this->hasMany('App\Models\Popis', 'id_magacina');
    }

    public function prijemnice()
    {
        return $this->hasMany('App\Models\Prijemnica', 'id_magacina');
    }

    public function stanje()
    {
        return $this->hasMany('App\Models\Stanje', 'id_magacina');
    }
}
