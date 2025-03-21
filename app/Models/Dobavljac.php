<?php

namespace App\Models;

use App\Classes\Model;

class Dobavljac extends Model
{
    protected string $table = 'dobavljaci';

    public function prijemnice()
    {
        return $this->hasMany('App\Models\Prijemnica', 'id_dobavljaca');
    }

}
