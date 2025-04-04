<?php

namespace App\Models;

use App\Classes\Model;

class TipNaloga extends Model
{
    protected string $table = 'tipovi_naloga';

    public function nalozi()
    {
        $sql = "SELECT * FROM nalozi WHERE id_tipa = :tip;";
        $nalozi = (new Nalog())->fetch($sql, [':tip' => $this->id]);
        return $nalozi;
    }
}
