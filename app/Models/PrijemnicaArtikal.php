<?php

namespace App\Models;

use App\Classes\Model;

class PrijemnicaArtikal extends Model
{
    protected string $table = 'prijemnica_artikal';

    public function prijemnica()
    {
        return $this->belongsTo('App\Models\Prijemnica', 'id_prijemnice');
    }

    public function artikal()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla');
    }

    public function artikliPrijemnice(int $id_artikla)
    {
        $sql = "SELECT * FROM prijemnica_artikal WHERE id_artikla = :id_artikla;";
        return $this->fetch($sql, [':id_artikla' => $id_artikla]);
    }
}