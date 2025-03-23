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
}
