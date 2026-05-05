<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\DocumentAlumne;

class DocumentAlumneModel extends Model
{
    protected $table      = 'document_alumne';
    protected $primaryKey = 'id_document';
    protected $returnType = DocumentAlumne::class;

    protected $useTimestamps = true;
    protected $createdField  = 'creat_el';
    protected $updatedField  = '';

    protected $allowedFields = [
        'id_alumne',
        'nom_original',
        'nom_fitxer',
        'ruta',
        'tipus',
        'any_academic',
    ];

    public function getDocumentsPerAlumne($idAlumne)
    {
        $binaryId = hex2bin(str_replace('-', '', $idAlumne));
        return $this->where('id_alumne', $binaryId)
            ->orderBy('creat_el', 'DESC')
            ->findAll();
    }

    public function getDocumentsPerAlumneIAny($idAlumne, $any)
    {
        $binaryId = hex2bin(str_replace('-', '', $idAlumne));
        return $this->where('id_alumne', $binaryId)
            ->where('any_academic', $any)
            ->orderBy('creat_el', 'DESC')
            ->findAll();
    }
}