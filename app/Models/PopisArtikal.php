<?php

namespace App\Models;

use App\Classes\Model;

class PopisArtikal extends Model
{
    protected string $table = 'popis_artikal';

    public function popis()
    {
        return (new Popis())->find($this->id_popisa);
    }

    public function artikal()
    {
        return (new Artikal())->find($this->id_artikla);
    }
}