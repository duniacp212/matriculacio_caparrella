<?php

namespace App\Models;

use CodeIgniter\Model;

class ServeiComplementariModel extends Model
{
    protected $table      = 'serveis_complementaris';
    protected $primaryKey = 'id_servei';
    protected $returnType = 'array';

    protected $allowedFields = [
        'tipus',
        'estat',
        'preu'
    ];
}