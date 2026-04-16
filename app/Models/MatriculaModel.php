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

    public function getMatriculaAmbDades($id)
    {
        return $this->db->table('matricula m')
            ->select('
            m.id_matricula,
            m.data,
            m.data_pagament,
            m.estat,
            m.torn,
            m.observacions,
            a.nom,
            a.cognom1,
            a.cognom2,
            a.dni,
            e.tipus,
            e.nivell,
            b.tipus as bonificacio_nom,
            b.percentatge as bonificacio_percentatge
        ')
            ->join('alumne a', 'a.id_alumne = m.id_alumne')
            ->join('estudi e', 'e.id_estudi = m.id_estudi')
            ->join('matricula_bonificacio mb', 'mb.id_matricula = m.id_matricula', 'left')
            ->join('bonificacio b', 'b.id_bonificacio = mb.id_bonificacio', 'left')
            ->where('m.id_matricula', $id)
            ->get()
            ->getRowArray();
    }
}
