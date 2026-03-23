<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FamiliaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_familia' => 1, 'nom' => 'ESO'],
            ['id_familia' => 2, 'nom' => 'Batxillerat'],
            ['id_familia' => 3, 'nom' => 'Formació Professional: Grau Mitjà'],
            ['id_familia' => 4, 'nom' => 'Formació Professional: Grau Superior'],
            ['id_familia' => 5, 'nom' => 'Formació Professional: PFI'],
            ['id_familia' => 6, 'nom' => 'Formació Professional Bàsica'],
        ];

        $this->db->table('familia')->ignore(true)->insertBatch($data);
    }
}
