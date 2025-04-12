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

    public function otpisArtikli(int $id_artikla)
    {
        $sql = "SELECT * FROM otpisi WHERE id_artikla = :id_artikla ORDER BY datum DESC;";
        return $this->fetch($sql, [':id_artikla' => $id_artikla]);
    }

    public function otpisArtikliSum(int $id_artikla)
    {
        $sql = "SELECT SUM(kolicina) AS kolicina FROM otpisi WHERE id_artikla = :id_artikla;";
        $kolicina = $this->fetch($sql, [':id_artikla' => $id_artikla]);
        return $kolicina[0]->kolicina ?? 0;
    }

    public function artikliOtpis(int $id_artikla)
    {
        $sql = "SELECT * FROM otpisi WHERE id_artikla = :id_artikla;";
        return $this->fetch($sql, [':id_artikla' => $id_artikla]);
    }
}
