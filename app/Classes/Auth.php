<?php

namespace App\Classes;

use App\Models\Korisnik;

class Auth
{
    private $model;

    public function __construct()
    {
        $this->model = new Korisnik();
    }

    public function login($username, $password)
    {
        $user = $this->model->findByUsername($username);
        if (!$user) {
            return false;
        }

        // Ako je korisnik nivo 9999 onda je "obrisan" (ne moze da se prijavi)
        if ($user->nivo == 9999) {
            return false;
        }

        if ($this->checkPassword($password, $user->lozinka)) {
            $_SESSION['korisnik'] = $user->id;

            return true;
        }
        return false;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['korisnik']);
    }

    public function korisnik()
    {
        if (isset($_SESSION['korisnik'])) {
            return $this->model->find((int)$_SESSION['korisnik']);
        }
        return null;
    }

    public function logout()
    {
        unset($_SESSION['korisnik']);
    }

    public function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
