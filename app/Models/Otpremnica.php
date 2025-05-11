<?php

namespace App\Models;

use App\Classes\Model;

class Otpremnica extends Model
{
    protected string $table = 'otpremnice';

    public function kupac()
    {
        return $this->belongsTo('App\Models\Kupac', 'id_kupca');
    }

    public function magacin()
    {
        return (new Magacin())->find($this->id_magacina);
    }

    public function stavke()
    {
        return $this->hasMany('App\Models\OtpremnicaArtikal', 'id_otpremnice');
    }

    public function ukupanIzanos()
    {
        $sql = "SELECT SUM(kolicina * cena) AS ukupno FROM otpremnica_artikal WHERE id_otpremnice = :id_otpremnice;";
        $params = [":id_otpremnice" => $this->id];
        $iznos = $this->fetch($sql, $params);
        $ukupno = $iznos[0] ? $iznos[0]->ukupno : 0;
        return $ukupno;
    }

    public function placeniIzanos()
    {
        $sql = "SELECT SUM(iznos) AS ukupno FROM otpremnica_artikal WHERE id_otpremnice = :id_otpremnice;";
        $params = [":id_otpremnice" => $this->id];
        $iznos = $this->fetch($sql, $params);
        $ukupno = $iznos[0] ? $iznos[0]->ukupno : 0;
        return $ukupno;
    }

    public function dugIzanos()
    {
        return $this->ukupanIzanos() - $this->placeniIzanos();
    }
}
