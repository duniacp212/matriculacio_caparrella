<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignaturaModel extends Model
{
    protected $table            = 'assignatura';
    protected $primaryKey       = 'id_assignatura';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nom', 'id_estudi'];
}
