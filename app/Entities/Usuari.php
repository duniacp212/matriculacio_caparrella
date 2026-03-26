<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Usuari extends Entity
{
    protected $attributes = [
        'id_usuari' => null,
        'nom' => null,
        'cognom1' => null,
        'cognom2' => null,
        'dni_nie' => null,
        'usuari' => null,
        'password' => null,
        'rol' => null
    ];

    public function setPassword(string $pass)
    {
        $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
        return $this;
    }
}
