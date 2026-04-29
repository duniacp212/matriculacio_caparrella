<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MatriculaSeeder extends Seeder
{
    public function run()
    {
        $alumnes = $this->db->table('alumne')->select('id_alumne')->get()->getResultArray();
        $estudis = $this->db->table('estudi')->select('id_estudi')->get()->getResultArray();
        $bonificacions = $this->db->table('bonificacio')->select('id_bonificacio')->get()->getResultArray();

        if (empty($alumnes) || empty($estudis)) {
            return;
        }

        $data = [];

        foreach ($alumnes as $alumne) {
            $data[] = [
                'id_alumne'     => $alumne['id_alumne'],
                'id_estudi'     => $estudis[array_rand($estudis)]['id_estudi'],
                'data'          => date('Y-m-d'),
                'estat' => rand(0, 1) ? 'Validat' : 'Pendent',
                'torn'          => rand(1, 3),
                'data_pagament' => rand(0, 1) ? date('Y-m-d') : null
            ];
        }

        $model = new \App\Models\MatriculaModel();
        foreach ($data as $dades) {
            $model->insert($dades);
        }

        if (!empty($bonificacions)) {
            $matricules = $this->db->table('matricula')->select('id_matricula')->get()->getResultArray();

            $assignacions = [];
            foreach ($matricules as $matricula) {
                if (rand(1, 10) <= 3) {
                    $assignacions[] = [
                        'id_matricula'   => $matricula['id_matricula'],
                        'id_bonificacio' => $bonificacions[array_rand($bonificacions)]['id_bonificacio'],
                        'estat'          => 'Validat',
                        'observacions'   => 'Introduït a través del seeder',
                    ];
                }
            }

            if (!empty($assignacions)) {
                $this->db->table('matricula_bonificacio')->insertBatch($assignacions);
            }
        }
    }
}