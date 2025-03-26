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

    public function adresa()
    {
        if (!empty($this->adresa_ulica) && !empty($this->adresa_broj) && !empty($this->adresa_mesto)) {
            return $this->adresa_ulica . ' ' . $this->adresa_broj. ', ' . $this->adresa_mesto;
        } elseif (empty($this->adresa_ulica) && !empty($this->adresa_broj) && !empty($this->adresa_mesto)) {
            return 'Кућни број: ' . $this->adresa_broj. ', ' . $this->adresa_mesto;
        } elseif (empty($this->adresa_ulica) && empty($this->adresa_broj) && !empty($this->adresa_mesto)) {
            return $this->adresa_mesto;
        } else{
            return null;
        }
    }

}
