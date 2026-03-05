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
        $builder = $this->db->table('matricula m')
            ->select('
                e.tipus,
                e.nivell,
                m.torn,
                COUNT(*) as total
            ')
            ->join('estudi e', 'e.id_estudi = m.id_estudi')
            ->groupBy(['e.tipus', 'e.nivell', 'm.torn'])
            ->orderBy('e.tipus')
            ->orderBy('e.nivell');

        return $builder->get()->getResultArray();
    }

    public function getMatriculaPerAlumne($idAlumne)
    {
        return $this->where('id_alumne', $idAlumne)->findAll();
    }

    public function getTorns()
    {
        return $this->select('torn')
            ->distinct()
            ->orderBy('torn')
            ->findAll();
    }
}