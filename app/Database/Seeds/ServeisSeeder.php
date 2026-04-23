<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServeisSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tipus' => 'Granota',
                'estat' => 'actiu',
                'preu'  => 25.00,
            ],
            [
                'tipus' => 'Taquilla 50%',
                'estat' => 'actiu',
                'preu'  => 35.00,
            ],
            [
                'tipus' => 'Taquilla 100%',
                'estat' => 'actiu',
                'preu'  => 70.00,
            ],
        ];

        foreach ($data as $d) {
            $exists = $this->db->table('serveis_complementaris')->where('tipus', $d['tipus'])->get()->getRowArray();
            if (!$exists) {
                $this->db->table('serveis_complementaris')->insert($d);
            }
        }
    }
}