<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriculaModel extends Model
{
    protected $table = 'matricula';
    protected $primaryKey = 'id_matricula';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_alumne',
        'id_estudi',
        'id_poble',
        'data',
        'data_pagament',
        'estat',
        'torn',
        'observacions'
    ];

    public function getResumMatriculats()
    {
        return $this->db->table('matricula m')
            ->select('
                e.tipus,
                e.nivell,
                m.torn,
                COUNT(*) as total
            ')
            ->join('estudi e', 'e.id_estudi = m.id_estudi')
            ->groupBy(['e.tipus', 'e.nivell', 'm.torn'])
            ->orderBy('e.tipus')
            ->orderBy('e.nivell')
            ->get()
            ->getResultArray();
    }

    public function getMatriculaPerAlumne($idAlumne)
    {
        return $this->db->table('matricula m')
            ->select('
                m.id_matricula,
                m.data,
                m.data_pagament,
                m.estat,
                m.torn,
                m.observacions,
                e.tipus,
                e.nivell,
                a.nom,
                a.cognom1,
                a.cognom2,
                a.dni
            ')
            ->join('alumne a', 'a.id_alumne = m.id_alumne')
            ->join('estudi e', 'e.id_estudi = m.id_estudi')
            ->where('m.id_alumne', $idAlumne)
            ->get()
            ->getRowArray();
    }

    public function getTorns()
    {
        return $this->select('torn')
            ->distinct()
            ->orderBy('torn')
            ->findAll();
    }
}