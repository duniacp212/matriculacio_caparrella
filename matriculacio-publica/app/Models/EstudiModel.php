<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiModel extends Model
{
    protected $table = 'estudi';
    protected $primaryKey = 'id_estudi';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_familia',
        'tipus',
        'nivell',
        'estat'
    ];

    protected $useTimestamps = false;
}