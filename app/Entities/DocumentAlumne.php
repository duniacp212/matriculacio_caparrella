<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Entities\Casts\UuidV7Cast;

class DocumentAlumne extends Entity
{
    protected $casts = [
        'id_document' => 'uuid_v7',
        'id_alumne'   => 'uuid_v7',
    ];

    protected $castHandlers = [
        'uuid_v7' => UuidV7Cast::class,
    ];
}
