<?php

namespace App\Models;

use App\Classes\Model;

class OtpremnicaArtikal extends Model
{
    protected string $table = 'otpremnica_artikal';

    public function prijemnica()
    {
        return $this->belongsTo('App\Models\Otpremnica', 'id_otpremnice');
    }

    public function artikal()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla');
    }
}