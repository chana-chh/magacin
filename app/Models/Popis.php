<?php

namespace App\Models;

use App\Classes\Model;  

class Popis extends Model
{
    protected string $table = 'popisi';

    public function magacin()
    {
        return (new Magacin())->find($this->id_magacina);
    }

}