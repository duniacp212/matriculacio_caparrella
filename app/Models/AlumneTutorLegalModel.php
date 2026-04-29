<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\AlumneTutorLegal;

class AlumneTutorLegalModel extends Model
{
    protected $table = 'alumne_tutor_legal';
    protected $primaryKey = 'id_tutor';
    protected $returnType = AlumneTutorLegal::class;
    protected $allowedFields = [
        'nom',
        'cognom1',
        'cognom2',
        'telefon',
        'email',
        'dni',
        'rol',
        'id_alumne'
    ];

    public function getTutorsPerAlumne($idAlumne)
    {
        $binaryId = hex2bin(str_replace('-', '', $idAlumne));
        return $this->where('id_alumne', $binaryId)->findAll();
    }
}
