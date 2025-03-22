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
}
