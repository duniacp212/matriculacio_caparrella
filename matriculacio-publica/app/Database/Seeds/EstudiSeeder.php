<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstudiSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('estudi')->truncate();

        $data = [
            ['id_estudi' =>  1, 'id_familia' => 1, 'tipus' => 'ESO', 'nivell' => '1', 'estat' => 'actiu'],
            ['id_estudi' =>  2, 'id_familia' => 1, 'tipus' => 'ESO', 'nivell' => '2', 'estat' => 'actiu'],
            ['id_estudi' =>  3, 'id_familia' => 1, 'tipus' => 'ESO', 'nivell' => '3', 'estat' => 'actiu'],
            ['id_estudi' =>  4, 'id_familia' => 1, 'tipus' => 'ESO', 'nivell' => '4', 'estat' => 'actiu'],
            ['id_estudi' =>  5, 'id_familia' => 2, 'tipus' => 'BAT', 'nivell' => '1', 'estat' => 'actiu'],
            ['id_estudi' =>  6, 'id_familia' => 2, 'tipus' => 'BAT', 'nivell' => '2', 'estat' => 'actiu'],
            ['id_estudi' =>  7, 'id_familia' => 3, 'tipus' => 'SMX', 'nivell' => '1', 'estat' => 'actiu'],
            ['id_estudi' =>  8, 'id_familia' => 3, 'tipus' => 'SMX', 'nivell' => '2', 'estat' => 'actiu'],
            ['id_estudi' =>  9, 'id_familia' => 3, 'tipus' => 'DAM', 'nivell' => '1', 'estat' => 'actiu'],
            ['id_estudi' => 10, 'id_familia' => 3, 'tipus' => 'DAM', 'nivell' => '2', 'estat' => 'actiu'],
            ['id_estudi' => 11, 'id_familia' => 3, 'tipus' => 'DAW', 'nivell' => '1', 'estat' => 'actiu'],
            ['id_estudi' => 12, 'id_familia' => 3, 'tipus' => 'DAW', 'nivell' => '2', 'estat' => 'actiu'],
        ];

        $this->db->table('estudi')->insertBatch($data);
    }
}