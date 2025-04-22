<?php

namespace App\Models;

use App\Classes\Model;

class JedinicaMere extends Model
{
    protected string $table = 'jedinice_mere';

    public function artikli()
    {
        return $this->hasMany('App\Models\Artikal', 'id_jm');
    }

}
