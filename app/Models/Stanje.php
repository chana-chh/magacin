<?php

namespace App\Models;

use App\Classes\Model;

class Stanje extends Model
{
    protected string $table = 'stanje';

    public function artikal()
    {
        return $this->belongsTo('App\Models\Artikal', 'id_artikla');
    }

    // public function magacin()
    // {
    //     return $this->belongsTo('App\Models\Magacin', 'id_magacina');
    // }

    public function dodajKolicinu(int $id_magacina, int $id_artikla, float $kolicina)
    {
        $kolicina = round($kolicina, 2);
        // Pronadji stanje (ako ne postoji kreiraj ga)
        $sql = "SELECT * FROM stanje WHERE id_magacina = :id_magacina AND id_artikla = :id_artikla;";
        $stanje = $this->fetch($sql, [':id_magacina' => $id_magacina, ':id_artikla' => $id_artikla]);
        if (count($stanje) === 0) {
            $id = $this->insert(['id_magacina' => $id_magacina, 'id_artikla' => $id_artikla, 'kolicina' => $kolicina]);
            $stanje = $this->find($id);
        } else {
            $stanje = $stanje[0];
            $nova_kolicina = $stanje->kolicina + $kolicina;
            $this->update(['kolicina' => $nova_kolicina], $stanje->id);
        }
    }

    public function oduzmiKolicinu(int $id_magacina, int $id_artikla, float $kolicina)
    {
        $kolicina = round($kolicina, 2);
        $sql = "SELECT * FROM stanje WHERE id_magacina = :id_magacina AND id_artikla = :id_artikla;";
        $stanje = $this->fetch($sql, [':id_magacina' => $id_magacina, ':id_artikla' => $id_artikla]);
        $stanje = $stanje[0] ?? null;
        if (!$stanje || $stanje->kolicina < $kolicina) {
            throw new \Exception('Нема довољне количине на стању!');
        }
        $nova_kolicina = $stanje->kolicina - $kolicina;
        $this->update(['kolicina' => $nova_kolicina], $stanje->id);
    }

    public function stanjeMagacin(int $id_magacina)
    {
        $sql = "SELECT * FROM stanje WHERE id_magacina = :id_magacina";
        $stanje = $this->fetch($sql, [':id_magacina' => $id_magacina]);
        return $stanje;
    }

    public function stanjeMagacinArtikal(int $id_magacina , int $id_artikla)
    {
        $sql = "SELECT * FROM stanje WHERE id_magacina = :id_magacina AND id_artikla = :id_artikla;";
        $stanje = $this->fetch($sql, [':id_magacina' => $id_magacina, ':id_artikla' => $id_artikla]);
        $stanje = $stanje[0] ?? null;
        return $stanje;
    }
}
