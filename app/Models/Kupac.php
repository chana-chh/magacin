<?php

namespace App\Models;

use App\Classes\Model;

class Kupac extends Model
{
    protected string $table = 'kupci';

    public function otpremnice()
    {
        return $this->hasMany('App\Models\Otpremnica', 'id_kupca');
    }

}
