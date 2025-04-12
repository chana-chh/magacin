<?php

namespace App\Models;

use App\Classes\Model;

class Nalog extends Model
{
    protected string $table = 'nalozi';


    public function stavke()
    {
        return $this->hasMany('App\Models\NalogArtikal', 'id_naloga');
    }

    public function tip()
    {
        return $this->belongsTo('App\Models\TipNaloga', 'id_tipa');
    }

    public function magaciniiz()
    {
        $magacin = new Magacin();
        if (!$this->magacin_iz) {
            return null;
        }
        $niz = explode(',', $this->magacin_iz);
        $jed = array_unique($niz);
        $str = implode(',', $jed);
        $sql = "SELECT * FROM magacini WHERE id IN ({$str});";
        $magacini = $magacin->fetch($sql);
        return $magacini;
    }

    public function magaciniu()
    {
        $magacin = new Magacin();
        if (!$this->magacin_u) {
            return null;
        }
        $niz = explode(',', $this->magacin_u);
        $jed = array_unique($niz);
        $str = implode(',', $jed);
        $sql = "SELECT * FROM magacini WHERE id IN ({$str});";
        $magacini = $magacin->fetch($sql);
        return $magacini;
    }

    public function artikaliz()
    {
        $artikal = new Artikal();
        if (!$this->artikli_iz) {
            return null;
        }
        $niz = explode(',', $this->artikli_iz);
        $jed = array_unique($niz);
        $str = implode(',', $jed);
        $sql = "SELECT * FROM artikli WHERE id IN ({$str});";
        $artikli = $artikal->fetch($sql);
        return $artikli;
    }

    public function artikalu()
    {
        $artikal = new Artikal();
        if (!$this->artikli_u) {
            return null;
        }
        $niz = explode(',', $this->artikli_u);
        $jed = array_unique($niz);
        $str = implode(',', $jed);
        $sql = "SELECT * FROM artikli WHERE id IN ({$str});";
        $artikli = $artikal->fetch($sql);
        return $artikli;
    }
}
