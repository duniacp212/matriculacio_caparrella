<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiModel extends Model
{
    protected $table = 'estudi';
    protected $primaryKey = 'id_estudi';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'id_familia',
        'matricula_viva'
    ];

    public function obtenirTots()
    {
        return $this->orderBy('nom')->findAll();
    }

    public function actualitzarMatriculaViva(array $estudisActius)
    {
        $tots = $this->findAll();

        foreach ($tots as $estudi) {

            $this->update($estudi['id_estudi'], [
                'matricula_viva' => in_array($estudi['id_estudi'], $estudisActius) ? 1 : 0
            ]);
        }
    }
}
