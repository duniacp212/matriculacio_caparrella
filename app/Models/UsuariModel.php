<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariModel extends Model
{
    protected $table = 'usuari';
    protected $primaryKey = 'id_usuari';

    protected $allowedFields = [
        'usuari',
        'password',
        'rol'
    ];
}