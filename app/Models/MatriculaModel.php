<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriculaModel extends Model
{
    protected $table = 'matricules';
    protected $primaryKey = 'id_matricula';

    public function obtenirAlumnesAmbFiltres(array $filtres)
    {
        $builder = $this->db->table('alumnes');
        $builder->select('
            alumnes.id_alumne,
            alumnes.nom,
            alumnes.cognoms,
            alumnes.dni,
            matricules.any_matricula,
            matricules.estudi,
            matricules.curs,
            matricules.familia,
            matricules.cicle,
            matricules.estat,
            matricules.pagament
        ');
        $builder->join(
            'matricules',
            'matricules.id_alumne = alumnes.id_alumne',
            'left'
        );

        foreach ($filtres as $camp => $valor) {
            if ($valor) {
                $builder->where('matricules.' . $camp, $valor);
            }
        }

        return $builder->get()->getResultArray();
    }
}
