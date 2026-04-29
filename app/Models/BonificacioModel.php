<?php

namespace App\Models;

use CodeIgniter\Model;

class BonificacioModel extends Model
{
    protected $table            = 'bonificacio';
    protected $primaryKey       = 'id_bonificacio';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['tipus', 'descripcio', 'percentatge'];
}
