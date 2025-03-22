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
}
