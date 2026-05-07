<?php

namespace App\Models;

use CodeIgniter\Model;

class PobleModel extends Model
{
    protected $table = 'poble';
    protected $primaryKey = 'id_poble';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nom'
    ];

    protected $useTimestamps = false;
}