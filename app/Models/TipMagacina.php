<?php

namespace App\Models;

use App\Classes\Model;

class TipMagacina extends Model
{
    protected string $table = 'tipovi_magacina';

    public function magacini()
    {
        $sql = "SELECT * FROM magacini WHERE id_tipa = :tip;";
        $magacini = (new Magacin())->fetch($sql, [':tip' => $this->id]);
        return $magacini;
    }
}
