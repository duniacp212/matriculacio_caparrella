<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\DocumentAlumne;

class DocumentAlumneModel extends Model
{
    protected $table      = 'document_alumne';
    protected $primaryKey = 'id_document';
    protected $returnType = DocumentAlumne::class;
    protected $useAutoIncrement = false;

    protected $useTimestamps = true;
    protected $createdField  = 'creat_el';
    protected $updatedField  = '';

    protected $allowedFields = [
        'id_document',
        'id_alumne',
        'nom_original',
        'nom_fitxer',
        'ruta',
        'tipus',
        'any_academic',
    ];

    protected $beforeInsert = ['generateUuidV7'];

    protected function generateUuidV7(array $data)
    {
        if (! isset($data['data']['id_document'])) {
            $uuid = \Ramsey\Uuid\Uuid::uuid7();
            $data['data']['id_document'] = $uuid->getBytes();
        }

        return $data;
    }

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