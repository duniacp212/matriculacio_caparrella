<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiModel extends Model
{
    protected $table = 'estudi';
    protected $primaryKey = 'id_estudi';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tipus',
        'nivell',
        'id_familia',
        'matricula_viva'
    ];

    public function crearAmbAssignatures(array $dadesCurs, array $assignatures, array $optatives)
    {
        $this->insert($dadesCurs);
        $idEstudi = $this->insertID();

        if (!empty($assignatures)) {
            foreach ($assignatures as $nom) {
                if (!empty(trim($nom))) {
                    $this->db->table('assignatura')->insert([
                        'nom' => $nom,
                        'id_estudi' => $idEstudi
                    ]);
                }
            }
        }

        if (!empty($optatives)) {
            foreach ($optatives as $nom) {
                if (!empty(trim($nom))) {
                    $this->db->table('optativa')->insert([
                        'nom' => $nom,
                        'id_estudi' => $idEstudi
                    ]);
                }
            }
        }

        return $idEstudi;
    }

    public function obtenirTots()
    {
        return $this->orderBy('tipus', 'ASC')
            ->orderBy('nivell', 'ASC')
            ->findAll();
    }

    public function obtenirCicles()
    {
        return $this->select('tipus')
            ->distinct()
            ->orderBy('tipus')
            ->findAll();
    }

    public function obtenirCursos()
    {
        return $this->select('nivell')
            ->distinct()
            ->orderBy('nivell')
            ->findAll();
    }

    public function obtenirEstudis()
    {
        return $this->select('tipus')
            ->distinct()
            ->orderBy('tipus')
            ->findAll();
    }

    public function obtenirFamilies()
    {
        return $this->db->table('familia')
            ->select('id_familia, nom')
            ->orderBy('nom')
            ->get()
            ->getResultArray();
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