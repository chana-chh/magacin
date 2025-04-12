<?php

namespace App\Models;

use App\Classes\Model;

class Prijemnica extends Model
{
    protected string $table = 'prijemnice';

    public function dobavljac()
    {
        return $this->belongsTo('App\Models\Dobavljac', 'id_dobavljaca');
    }

    public function magacin()
    {
        return (new Magacin())->find($this->id_magacina);
    }

    public function stavke()
    {
        return $this->hasMany('App\Models\PrijemnicaArtikal', 'id_prijemnice');
    }

    public function ukupanIzanos()
    {
        if (count($this->stavke()) === 0){
            return 0;
        }
        $sql = "SELECT SUM(iznos) AS ukupno FROM prijemnica_artikal WHERE id_prijemnice = :id_prijemnice;";
        $params = [":id_prijemnice" => $this->id];
        $iznos = $this->fetch($sql, $params);
        $ukupno = $iznos[0] ? $iznos[0]->ukupno : 0;
        return $ukupno;
    }

    public function placeniIzanos()
    {
        if (count($this->stavke()) === 0) {
            return 0;
        }
        $sql = "SELECT SUM(iznos) AS ukupno FROM prijemnica_artikal WHERE id_prijemnice = :id_prijemnice AND placeno = 1;";
        $params = [":id_prijemnice" => $this->id];
        $iznos = $this->fetch($sql, $params);
        $ukupno = $iznos[0] ? $iznos[0]->ukupno : 0;
        return $ukupno;
    }

    public function dugIzanos()
    {
        if (count($this->stavke()) === 0) {
            return 0;
        }
        $sql = "SELECT SUM(iznos) AS ukupno FROM prijemnica_artikal WHERE id_prijemnice = :id_prijemnice AND placeno = 0;";
        $params = [":id_prijemnice" => $this->id];
        $iznos = $this->fetch($sql, $params);
        $ukupno = $iznos[0] ? $iznos[0]->ukupno : 0;
        return $ukupno;
    }
}
