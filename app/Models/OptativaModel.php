<?php

namespace App\Models;

use CodeIgniter\Model;

class OptativaModel extends Model
{
    protected $table            = 'optativa';
    protected $primaryKey       = 'id_optativa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nom', 'id_estudi'];
}
