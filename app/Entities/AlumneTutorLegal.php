<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Entities\Casts\UuidV7Cast;

class AlumneTutorLegal extends Entity
{
    protected $casts = [
        'id_alumne' => 'uuid_v7',
    ];

    protected $castHandlers = [
        'uuid_v7' => UuidV7Cast::class,
    ];
}
