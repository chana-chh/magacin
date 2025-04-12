<?php

namespace App\Models;

use App\Classes\Model;

class OtpremnicaArtikal extends Model
{
    protected string $table = 'otpremnica_artikal';

    public function otpremnica()
    {
        return $this->belongsTo('App\Models\Otpremnica', 'id_otpremnice');
    }

    public function artikal()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla');
    }

    public function artikliOtpremnice(int $id_artikla)
    {
        $sql = "SELECT * FROM otpremnica_artikal WHERE id_artikla = :id_artikla";
        return $this->fetch($sql, [':id_artikla' => $id_artikla]);
    }
}