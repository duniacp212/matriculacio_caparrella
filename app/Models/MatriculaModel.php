<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Matricula;
use Ramsey\Uuid\Uuid;

class MatriculaModel extends Model
{
    protected $table = 'matricula';
    protected $primaryKey = 'id_matricula';
    protected $returnType = Matricula::class;
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'id_matricula',
        'id_alumne',
        'id_estudi',
        'id_poble',
        'data',
        'data_pagament',
        'estat',
        'torn',
        'observacions'
    ];

    protected $beforeInsert = ['generateUuidV7'];

    protected function generateUuidV7(array $data)
    {
        if (!isset($data['data']['id_matricula'])) {
            $uuid = Uuid::uuid7();
            $data['data']['id_matricula'] = $uuid->getBytes();
        }

        return $data;
    }

    public function getResumMatriculats($any = null)
    {
        $builder = $this->db->table('matricula m')
            ->select('
                e.tipus as estudi,
                e.tipus as cicle,
                e.nivell as curs,
                m.torn,
                COUNT(*) as total
            ')
            ->join('estudi e', 'e.id_estudi = m.id_estudi')
            ->groupBy(['e.tipus', 'e.nivell', 'm.torn'])
            ->orderBy('e.tipus')
            ->orderBy('e.nivell');

        if (!empty($any)) {
            $builder->where('YEAR(m.data)', $any);
        }

        return $builder->get()->getResultArray();
    }

    public function getMatriculaPerAlumne($idAlumne)
    {
        $binaryId = hex2bin(str_replace('-', '', $idAlumne));
        return $this->db->table('matricula m')
            ->select('m.*, e.tipus, e.nivell')
            ->join('estudi e', 'e.id_estudi = m.id_estudi')
            ->where('m.id_alumne', $binaryId)
            ->get()
            ->getFirstRow(Matricula::class);
    }

    public function getTorns()
    {
        return $this->select('torn')
            ->distinct()
            ->orderBy('torn')
            ->findAll();
    }

    public function getMatriculaAmbDades($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        return $this->db->table('matricula m')
            ->select('
            m.id_matricula,
            m.id_alumne,
            m.data,
            m.data_pagament,
            m.estat,
            m.torn,
            a.observacions as observacions_alumne,
            m.observacions as observacions_matricula,
            a.nom,
            a.cognom1,
            a.cognom2,
            a.dni,
            a.data_naixement,
            a.email,
            a.telefon,
            a.telefon2,
            a.carrer,
            a.numero,
            a.pis,
            a.codi_postal,
            a.poblacio,
            a.nacionalitat,
            a.lloc_naixement,
            e.tipus,
            e.nivell,
            YEAR(m.data) as any_matricula,
            b.tipus as bonificacio_nom,
            b.percentatge as bonificacio_percentatge
        ')
            ->join('alumne a', 'a.id_alumne = m.id_alumne')
            ->join('estudi e', 'e.id_estudi = m.id_estudi')
            ->join('matricula_bonificacio mb', 'mb.id_matricula = m.id_matricula', 'left')
            ->join('bonificacio b', 'b.id_bonificacio = mb.id_bonificacio', 'left')
            ->where('m.id_matricula', $binaryId)
            ->get()
            ->getFirstRow(Matricula::class);
    }
}
