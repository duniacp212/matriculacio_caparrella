<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumneModel extends Model
{
    protected $table = 'alumne';
    protected $primaryKey = 'id_alumne';
    protected $returnType = 'array';

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

    public function getAlumnesAmbMatricula(array $filtres = [])
    {
        $builder = $this->db->table('alumne a')
            ->select('
            a.id_alumne,
            a.nom,
            a.cognom1,
            a.cognom2,
            a.dni,
            a.data_naixement,
            YEAR(m.data) as any_matricula,
            e.tipus as estudi,
            e.nivell as curs,
            f.nom as familia,
            m.estat,
            m.data_pagament,
            m.torn
        ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->join('familia f', 'f.id_familia = e.id_familia', 'left');

        if (!empty($filtres['any'])) {
            $builder->where('YEAR(m.data)', $filtres['any']);
        }

        if (!empty($filtres['estudi'])) {
            $builder->where('e.tipus', $filtres['estudi']);
        }

        if (!empty($filtres['curs'])) {
            $builder->where('e.nivell', $filtres['curs']);
        }

        if (!empty($filtres['familia'])) {
            $builder->where('f.nom', $filtres['familia']);
        }

        if (!empty($filtres['estat'])) {
            $builder->where('m.estat', $filtres['estat']);
        }

        if (!empty($filtres['cicle'])) {
            $builder->where('e.tipus', $filtres['cicle']);
        }

        if (!empty($filtres['pagament'])) {
            if ($filtres['pagament'] === 'pagat') {
                $builder->where('m.data_pagament IS NOT NULL', null, false);
            }

            if ($filtres['pagament'] === 'pendent') {
                $builder->where('m.data_pagament IS NULL', null, false);
            }
        }

        if (isset($filtres['torn'])) {
            $builder->where('m.torn', $filtres['torn']);
        }

        if (!empty($filtres['cerca'])) {
            $builder->groupStart()
                ->like('a.nom', $filtres['cerca'])
                ->orLike('a.cognom1', $filtres['cerca'])
                ->orLike('a.cognom2', $filtres['cerca'])
                ->orLike('a.dni', $filtres['cerca'])
                ->groupEnd();
        }

        $builder->orderBy('a.cognom1', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getContactePerId(int $id)
    {
        return $this->db->table('alumne a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognom1,
                a.cognom2,
                a.dni,
                a.email,
                a.telefon,
                e.tipus,
                e.nivell
            ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->where('a.id_alumne', $id)
            ->get()
            ->getRowArray();
    }

    public function getExpedientPerId(int $id)
    {
        return $this->db->table('alumne a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognom1,
                a.cognom2,
                a.dni,
                a.data_naixement,
                a.email,
                a.telefon,
                YEAR(m.data) as any_matricula,
                e.tipus,
                e.nivell,
                m.estat,
                m.torn
            ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->where('a.id_alumne', $id)
            ->get()
            ->getRowArray();
    }

    public function cercaGlobal($q)
    {
        return $this->db->table('alumne a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognom1,
                a.cognom2,
                a.dni,
                e.tipus,
                e.nivell,
                m.torn
            ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->groupStart()
            ->like('a.nom', $q)
            ->orLike('a.cognom1', $q)
            ->orLike('a.cognom2', $q)
            ->orLike('a.dni', $q)
            ->groupEnd()
            ->get()
            ->getResultArray();
    }
}
