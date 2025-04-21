<?php

namespace App\Models;

use App\Classes\Model;

class Artikal extends Model
{
    protected string $table = 'artikli';

    public function kategorija()
    {
        return (new KategorijaArtikla())->find($this->id_kategorije);
    }

    public function jm()
    {
        return (new JedinicaMere())->find($this->id_jm);
    }

    public function artikliNaloga()
    {
        return $this->hasMany('App\Models\NalogArtikal', 'id_artikla');
    }

    public function naloziIz()
    {
        return $this->hasMany('App\Models\Nalog', 'artikli_iz');
    }

    public function naloziU()
    {
        return $this->hasMany('App\Models\Nalog', 'artikli_u');
    }

    public function otpisi()
    {
        return $this->hasMany('App\Models\Otpis', 'id_artikla');
    }

    public function popisArtikli()
    {
        return $this->hasMany('App\Models\PopisArtikal', 'id_artikla');
    }

    public function artikliOtpremnice()
    {
        return $this->hasMany('App\Models\OtpremnicaArtikal', 'id_artikla');
    }

    public function artikliPrijemnice()
    {
        return $this->hasMany('App\Models\PrijemnicaArtikal', 'id_artikla');
    }

    public function stanje()
    {
        return $this->hasMany('App\Models\Stanje', 'id_artikla');
    }   
}
