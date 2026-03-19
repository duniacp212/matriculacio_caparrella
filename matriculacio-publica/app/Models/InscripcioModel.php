<?php

namespace App\Models;

use CodeIgniter\Model;

class InscripcioModel extends Model
{
    protected $table = 'matricula';
    protected $primaryKey = 'id_matricula';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_alumne',
        'id_estudi',
        'id_poble',
        'data_pagament',
        'data',
        'estat',
        'torn',
        'observacions'
    ];

    protected $useTimestamps = false;

    public function getByAlumne(int $id_alumne): ?array
    {
        return $this->where('id_alumne', $id_alumne)->first();
    }
}
