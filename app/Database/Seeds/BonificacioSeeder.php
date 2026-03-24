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

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('matricula_bonificacio')->truncate();
        $this->db->table('bonificacio')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $this->db->table('bonificacio')->insertBatch($bonificacions);

        $matricules = $this->db->table('matricula')->select('id_matricula')->get()->getResultArray();
        
        if (!empty($matricules)) {
            
            $bonificacionsIds = $this->db->table('bonificacio')->select('id_bonificacio')->get()->getResultArray();

            $assignacions = [];
            
            foreach ($matricules as $matricula) {
                if (rand(1, 10) <= 3) {
                    $bonificacioSeleccionada = $bonificacionsIds[array_rand($bonificacionsIds)]['id_bonificacio'];
                    
                    $assignacions[] = [
                        'id_matricula'   => $matricula['id_matricula'],
                        'id_bonificacio' => $bonificacioSeleccionada,
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
