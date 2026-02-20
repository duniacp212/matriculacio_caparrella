<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumneModel extends Model
{
    protected $table = 'alumnes';
    protected $primaryKey = 'id_alumne';
    protected $returnType = 'array';

    public function getAlumnesAmbMatricula(array $filtres = [])
    {
        $builder = $this->db->table('alumnes a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognoms,
                a.dni,
                a.data_naixement,
                m.any_matricula,
                m.estudi,
                m.curs,
                m.familia,
                m.cicle,
                m.estat,
                m.pagament,
                m.bonificats
            ')
            ->join('matricules m', 'm.id_alumne = a.id_alumne', 'left');

        if (!empty($filtres['any'])) {
            $builder->where('m.any_matricula', $filtres['any']);
        }

        if (!empty($filtres['estudi'])) {
            $builder->where('m.estudi', $filtres['estudi']);
        }

        if (!empty($filtres['curs'])) {
            $builder->where('m.curs', $filtres['curs']);
        }

        if (!empty($filtres['familia'])) {
            $builder->where('m.familia', $filtres['familia']);
        }

        if (!empty($filtres['cicle'])) {
            $builder->where('m.cicle', $filtres['cicle']);
        }

        if (!empty($filtres['estat'])) {
            $builder->where('m.estat', $filtres['estat']);
        }

        if (!empty($filtres['pagament'])) {
            $builder->where('m.pagament', $filtres['pagament']);
        }

        if (isset($filtres['bonificats']) && $filtres['bonificats'] !== '') {
            $builder->where('m.bonificats', $filtres['bonificats']);
        }

        if (!empty($filtres['torn'])) {
            $builder->where('m.torn', (int) $filtres['torn']);
        }

        if (!empty($filtres['cerca'])) {
            $builder->groupStart()
                ->like('a.nom', $filtres['cerca'])
                ->orLike('a.cognoms', $filtres['cerca'])
                ->orLike('a.dni', $filtres['cerca'])
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }

    public function getContactePerId(int $id)
    {
        return $this->db->table('alumnes a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognoms,
                a.dni,
                a.email,
                a.telefon,
                m.estudi,
                m.curs
            ')
            ->join('matricules m', 'm.id_alumne = a.id_alumne', 'left')
            ->where('a.id_alumne', $id)
            ->get()
            ->getRowArray();
    }

    public function getExpedientPerId(int $id)
    {
        return $this->db->table('alumnes a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognoms,
                a.dni,
                a.data_naixement,
                a.email,
                a.telefon,
                m.any_matricula,
                m.estudi,
                m.curs,
                m.familia,
                m.cicle,
                m.estat,
                m.pagament,
                m.bonificats
            ')
            ->join('matricules m', 'm.id_alumne = a.id_alumne', 'left')
            ->where('a.id_alumne', $id)
            ->get()
            ->getRowArray();
    }

    public function cercaGlobal($q)
    {
        return $this->db->table('alumnes a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognoms,
                a.dni,
                m.estudi,
                m.curs,
                m.torn
            ')
            ->join('matricules m', 'm.id_alumne = a.id_alumne', 'left')
            ->groupStart()
                ->like('a.nom', $q)
                ->orLike('a.cognoms', $q)
                ->orLike('a.dni', $q)
            ->groupEnd()
            ->get()
            ->getResultArray();
    }
}
