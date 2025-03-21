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

}
