<?php

namespace App\Models;

use App\Classes\Model;

class Otpis extends Model
{
    protected string $table = 'otpisi';

    public function artikal()
    {
        return (new Artikal())->find($this->id_artikla);
    }

    public function magacin()
    {
        return (new Magacin())->find($this->id_magacina);
    }
}
