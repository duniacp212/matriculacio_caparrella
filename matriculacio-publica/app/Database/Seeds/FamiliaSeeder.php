<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FamiliaSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('familia')->truncate();

        $data = [
            ['id_familia' => 1, 'nom' => 'ESO'],
            ['id_familia' => 2, 'nom' => 'Batxillerat'],
            ['id_familia' => 3, 'nom' => 'Informàtica i Comunicacions'],
            ['id_familia' => 4, 'nom' => 'Transport i Manteniment de Vehicles'],
            ['id_familia' => 5, 'nom' => 'Arts Gràfiques'],
        ];

        $this->db->table('familia')->insertBatch($data);
    }
}