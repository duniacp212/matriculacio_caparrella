<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariModel extends Model
{
    protected $table = 'usuari';
    protected $primaryKey = 'id_usuari';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'usuari',
        'password',
        'rol',
        'created_at'
    ];

    protected $useTimestamps = false;
}