<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriculaModel extends Model
{
    protected $table      = 'matricules';
    protected $primaryKey = 'id_matricula';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_alumne',
        'any_matricula',
        'estudi',
        'curs',
        'familia',
        'cicle',
        'estat',
        'pagament',
        'bonificats'
    ];


    public function getResumMatriculats($any = null)
    {
        $builder = $this->db->table($this->table);

        $builder->select("
            estudi,
            cicle,
            curs,
            SUM(CASE WHEN estat = 'Validat' THEN 1 ELSE 0 END) as total
        ");

        if (!empty($any)) {
            $builder->where('any_matricula', $any);
        }

        $builder->groupBy(['estudi', 'cicle', 'curs']);
        $builder->orderBy('estudi');
        $builder->orderBy('cicle');
        $builder->orderBy('curs');

        return $builder->get()->getResultArray();
    }


    public function getMatriculaPerAlumne($idAlumne)
    {
        return $this->where('id_alumne', $idAlumne)->findAll();
    }


    public function getAnysAcademics()
    {
        return $this->select('any_matricula')
            ->distinct()
            ->orderBy('any_matricula', 'DESC')
            ->findAll();
    }
}
