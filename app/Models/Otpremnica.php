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

}
