<?php

namespace App\Models;

use CodeIgniter\Model;

class BonificacioModel extends Model
{
    protected $table      = 'bonificacio';
    protected $primaryKey = 'id_bonificacio';

    protected $allowedFields = [
        'nom',
        'descripcio',
        'percentatge',
    ];

    protected $useTimestamps = false;
}