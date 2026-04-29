<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

use App\Entities\Casts\UuidV7Cast;

class Usuari extends Entity
{
    protected $casts = [
        'id_usuari' => 'uuid_v7',
    ];

    protected $castHandlers = [
        'uuid_v7' => UuidV7Cast::class,
    ];

    protected $attributes = [
        'id_usuari' => null,
        'nom' => null,
        'cognom1' => null,
        'cognom2' => null,
        'dni_nie' => null,
        'usuari' => null,
        'password' => null,
        'email' => null,
        'telefon' => null,
        'rol' => null
    ];

    public function setPassword(string $pass)
    {
        $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
        return $this;
    }
}
