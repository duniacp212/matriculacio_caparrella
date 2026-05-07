<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\AlumneTutorLegal;

class AlumneTutorLegalModel extends Model
{
    protected $table = 'alumne_tutor_legal';
    protected $primaryKey = 'id_tutor';
    protected $returnType = AlumneTutorLegal::class;
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'id_tutor',
        'nom',
        'cognom1',
        'cognom2',
        'telefon',
        'email',
        'dni',
        'rol',
        'id_alumne'
    ];

    protected $beforeInsert = ['generateUuidV7'];

    protected function generateUuidV7(array $data)
    {
        if (! isset($data['data']['id_tutor'])) {
            $uuid = \Ramsey\Uuid\Uuid::uuid7();
            $data['data']['id_tutor'] = $uuid->getBytes();
        }

        return $data;
    }

    public function getTutorsPerAlumne($idAlumne)
    {
        $binaryId = hex2bin(str_replace('-', '', $idAlumne));
        return $this->where('id_alumne', $binaryId)->findAll();
    }
}
