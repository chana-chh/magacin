<?php

namespace App\Models;

use DateTime;

class Stavka
{
    public DateTime $datum;
    public string $vrsta;
    public string $izlaz_tabela;
    public int $izlaz_id;
    public string $ulaz_tabela;
    public int $ulaz_id;
    public float $kolicina;
    public float $stanje;
    public int $ui; // 0 - izlaz, 1 - ulaz
    public float $iznos;
    public int $placeno; // 0 - nije placeno, 1 - placeno
}
