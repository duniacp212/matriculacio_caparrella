<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Usuari;
use Ramsey\Uuid\Uuid;

class UsuariModel extends Model
{
    protected $table            = 'usuari';
    protected $primaryKey       = 'id_usuari';
    protected $returnType       = Usuari::class;
    protected $useAutoIncrement = false;

    protected $useTimestamps = true;
    protected $createdField  = 'creat_el';
    protected $updatedField  = 'actualitzat_el';

    protected $allowedFields = [
        'id_usuari',
        'nom',
        'cognom1',
        'cognom2',
        'dni_nie',
        'usuari',
        'password',
        'email',
        'telefon',
        'rol'
    ];

    protected $beforeInsert = ['generateUuidV7'];

    protected function generateUuidV7(array $data)
    {
        if (! isset($data['data']['id_usuari'])) {
            $uuid = Uuid::uuid7();
            $data['data']['id_usuari'] = $uuid->getBytes();
        }

        return $data;
    }
}