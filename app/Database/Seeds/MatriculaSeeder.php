<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MatriculaSeeder extends Seeder
{
    public function run()
    {
        $alumnes = $this->db->table('alumne')->select('id_alumne')->get()->getResultArray();
        $estudis = $this->db->table('estudi')->select('id_estudi')->get()->getResultArray();

        if (empty($alumnes) || empty($estudis)) {
            return;
        }

        $data = [];

        foreach ($alumnes as $alumne) {
            $data[] = [
                'id_alumne' => $alumne['id_alumne'],
                'id_estudi' => $estudis[array_rand($estudis)]['id_estudi'],
                'data' => date('Y-m-d'),
                'estat' => 'activa',
                'torn' => rand(1, 3),
                'data_pagament' => rand(0, 1) ? date('Y-m-d') : null
            ];
        }

        $this->db->table('matricula')->insertBatch($data);
    }
}