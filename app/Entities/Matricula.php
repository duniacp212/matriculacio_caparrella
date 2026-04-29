<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Entities\Casts\UuidV7Cast;

class Matricula extends Entity
{
    protected $casts = [
        'id_matricula' => 'uuid_v7',
        'id_alumne'    => 'uuid_v7',
    ];

    protected $castHandlers = [
        'uuid_v7' => UuidV7Cast::class,
    ];

    protected $attributes = [
        'id_matricula' => null,
        'id_alumne' => null,
        'id_estudi' => null,
        'id_poble' => null,
        'data' => null,
        'data_pagament' => null,
        'estat' => null,
        'torn' => null,
        'observacions' => null
    ];
}
