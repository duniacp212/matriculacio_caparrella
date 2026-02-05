<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumnesModel extends Model
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
                m.pagament
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

        return $builder->get()->getResultArray();
    }
}
