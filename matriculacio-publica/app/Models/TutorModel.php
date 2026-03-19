<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorModel extends Model
{
    protected $table = 'alumne_tutor_legal';
    protected $primaryKey = 'id_tutor';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nom',
        'cognom1',
        'cognom2',
        'telefon',
        'email',
        'dni',
        'rol',
        'custodia_percentatge',
        'id_alumne'
    ];

    protected $useTimestamps = false;

    public function getByAlumne(int $id_alumne): ?array
    {
        return $this->where('id_alumne', $id_alumne)->findAll();
    }
}
