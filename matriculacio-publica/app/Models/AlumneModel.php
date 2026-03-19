<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumneModel extends Model
{
    protected $table = 'alumne';
    protected $primaryKey = 'id_alumne';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nom',
        'cognom1',
        'cognom2',
        'data_naixement',
        'telefon',
        'dni',
        'direccio',
        'email',
        'expedient'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation rules can be added as needed
    protected $validationRules = [];
    protected $validationMessages = [];
    

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function generarCodi(): string
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function verificarCredencials(string $dni, string $codi): ?array
    {
        return $this->where('dni', $dni)
                    ->where('codi', $codi)
                    ->where('codi_expiracio >=', date('Y-m-d H:i:s'))
                    ->first();
    }

    public function getByDNI(string $dni): ?array
    {
        return $this->where('dni', $dni)->first();
    }
}
