<?php

namespace App\Models;

use CodeIgniter\Model;

class TascaModel extends Model
{
    protected $table          = 'tasca';
    protected $primaryKey     = 'id_tasca';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'creat_el';
    protected $updatedField   = '';

    protected $allowedFields = [
        'titol',
        'descripcio',
        'data',
    ];
}