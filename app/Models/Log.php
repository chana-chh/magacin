<?php

namespace App\Models;

use App\Classes\Model;

class Log extends Model
{
    protected string $table = 'logovi';
    
    public function korisnik()
    {
        $sql = "SELECT * FROM korisnici WHERE id = {$this->id_korisnika}";
        return $this->fetch($sql)[0];
    }
}
