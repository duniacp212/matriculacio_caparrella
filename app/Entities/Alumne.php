<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Entities\Casts\UuidV7Cast;

class Alumne extends Entity
{
    protected $casts = [
        'id_alumne' => 'uuid_v7',
        'id_matricula' => 'uuid_v7',
    ];

    protected $castHandlers = [
        'uuid_v7' => UuidV7Cast::class,
    ];

    protected $attributes = [
        'id_alumne' => null,
        'nom' => null,
        'cognom1' => null,
        'cognom2' => null,
        'data_naixement' => null,
        'telefon' => null,
        'telefon2' => null,
        'dni' => null,
        'email' => null,
        'carrer' => null,
        'numero' => null,
        'pis' => null,
        'codi_postal' => null,
        'poblacio' => null,
        'nacionalitat' => null,
        'lloc_naixement' => null,
        'expedient' => null,
        'any_matricula' => null,
        'data_matricula' => null,
        'data_pagament' => null,
        'tipus' => null,
        'nivell' => null,
        'id_matricula' => null,
        'estat' => null,
        'torn' => null,
        'observacions' => null,
        'bonificats' => null,
        'bonificacio_nom' => null,
    ];
}
