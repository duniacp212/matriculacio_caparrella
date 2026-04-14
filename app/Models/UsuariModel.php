<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariModel extends Model
{
    protected $table            = 'usuari';
    protected $primaryKey       = 'id_usuari';
    protected $returnType       = \App\Entities\Usuari::class;
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $createdField  = 'creat_el';
    protected $updatedField  = 'actualitzat_el';

    protected $allowedFields = [
        'nom',
        'cognom1',
        'cognom2',
        'dni_nie',
        'usuari',
        'password',
        'rol'
    ];
}