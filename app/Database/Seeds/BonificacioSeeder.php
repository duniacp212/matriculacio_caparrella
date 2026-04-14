<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BonificacioSeeder extends Seeder
{
    public function run()
    {
        $bonificacions = [
            [
                'tipus'       => 'Família nombrosa general',
                'descripcio'  => 'Descompte del 50% per a famílies nombroses de categoria general.',
                'percentatge' => 50,
            ],
            [
                'tipus'       => 'Família nombrosa especial',
                'descripcio'  => 'Descompte del 100% per a famílies nombroses de categoria especial.',
                'percentatge' => 100,
            ],
            [
                'tipus'       => 'Família monoparental',
                'descripcio'  => 'Descompte del 50% per a famílies monoparentals.',
                'percentatge' => 50,
            ],
            [
                'tipus'       => 'Discapacitat >= 33%',
                'descripcio'  => 'Descompte del 100% per acreditació de discapacitat.',
                'percentatge' => 100,
            ],
        ];

        $this->db->table('bonificacio')->insertBatch($bonificacions);
    }
}