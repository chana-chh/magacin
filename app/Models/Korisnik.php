<?php

namespace App\Models;

use App\Classes\Model;
use Psr\Container\ContainerInterface;

class Korisnik extends Model
{
    protected string $table = 'korisnici';

    public function findByUsername(string $username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE korisnicko_ime = :kime LIMIT 1;";
        $params = [':kime' => $username];
        return $this->fetch($sql, $params)[0];
    }
}
