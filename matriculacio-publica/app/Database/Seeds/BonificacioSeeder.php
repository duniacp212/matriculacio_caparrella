<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BonificacioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_bonificacio' => 1,
                'nom' => 'Família nombrosa',
                'requereix_document' => 1,
                'percentatge' => 50.00,
                'descripcio' => 'Descompte per famílies nombroses'
            ],
            [
                'id_bonificacio' => 2,
                'nom' => 'Discapacitat',
                'requereix_document' => 1,
                'percentatge' => 100.00,
                'descripcio' => 'Exempció total per discapacitat'
            ],
            [
                'id_bonificacio' => 3,
                'nom' => 'Beca MEC',
                'requereix_document' => 0,
                'percentatge' => 100.00,
                'descripcio' => 'Beca del ministeri'
            ],
            [
                'id_bonificacio' => 4,
                'nom' => 'Família monoparental',
                'requereix_document' => 1,
                'percentatge' => 50.00,
                'descripcio' => 'Ajuda per famílies monoparentals'
            ],
        ];

        $this->db->table('bonificacio')->insertBatch($data);
    }
}