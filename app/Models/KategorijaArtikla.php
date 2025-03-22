<?php

namespace App\Models;

use App\Classes\Model;
use App\Models\Artikal;

class KategorijaArtikla extends Model
{
    protected string $table = 'kategorije_artikala';

    public function artikli()
    {
        $sql = "SELECT * FROM artikli WHERE id_kategorije = :kat;";
        $artikli = (new Artikal())->fetch($sql, [':kat' => $this->id]);
        return $artikli;
    }
}
