<?php

namespace App\Models;

use App\Classes\Model;

class NalogArtikal extends Model
{
    protected string $table = 'nalog_artikal';

    public function nalog()
    {
        return $this->belongsTo('App\Models\Nalog', 'id_naloga');
    }

    public function artikal()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla');
    }

    public function magacin()
    {
        return $this->belongsTo('App\Models\Magacin', 'id_magacina');
    }

    public function artikliNalozi(int $id_artikla)
    {
        $sql = "SELECT * FROM nalog_artikal WHERE id_artikla = :id_artikla";
        return $this->fetch($sql, [':id_artikla' => $id_artikla]);
    }
}