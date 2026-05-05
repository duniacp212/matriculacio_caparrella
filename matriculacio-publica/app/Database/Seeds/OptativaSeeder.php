<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OptativaSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('optativa')->truncate();

        // Optatives de prova per estudis de cicle.
        // IMPORTANT: `id_estudi` ha de coincidir amb `EstudiSeeder`.
        $data = [
            // SMX 1 (id_estudi=7)
            ['id_estudi' => 7,  'nom' => 'Robòtica bàsica',                     'estat' => 'actiu'],
            ['id_estudi' => 7,  'nom' => 'Impressió 3D',                        'estat' => 'actiu'],
            ['id_estudi' => 7,  'nom' => 'Introducció a Linux',                 'estat' => 'actiu'],
            ['id_estudi' => 7,  'nom' => 'Seguretat bàsica',                    'estat' => 'actiu'],
            ['id_estudi' => 7,  'nom' => 'Ofimàtica avançada',                  'estat' => 'actiu'],

            // SMX 2 (id_estudi=8)
            ['id_estudi' => 8,  'nom' => 'Ciberseguretat aplicada',             'estat' => 'actiu'],
            ['id_estudi' => 8,  'nom' => 'Administració de servidors Linux',    'estat' => 'actiu'],
            ['id_estudi' => 8,  'nom' => 'Virtualització',                      'estat' => 'actiu'],
            ['id_estudi' => 8,  'nom' => 'Xarxes avançades',                    'estat' => 'actiu'],
            ['id_estudi' => 8,  'nom' => 'Automatització amb scripts',          'estat' => 'actiu'],

            // DAM 1 (id_estudi=9)
            ['id_estudi' => 9,  'nom' => 'Programació competitiva',             'estat' => 'actiu'],
            ['id_estudi' => 9,  'nom' => 'Introducció a UX/UI',                 'estat' => 'actiu'],
            ['id_estudi' => 9,  'nom' => 'Bases de dades avançades',            'estat' => 'actiu'],
            ['id_estudi' => 9,  'nom' => 'Testing i qualitat de software',      'estat' => 'actiu'],
            ['id_estudi' => 9,  'nom' => 'Introducció a APIs REST',             'estat' => 'actiu'],

            // DAM 2 (id_estudi=10)
            ['id_estudi' => 10, 'nom' => 'Arquitectura de microserveis',        'estat' => 'actiu'],
            ['id_estudi' => 10, 'nom' => 'DevOps i CI/CD',                      'estat' => 'actiu'],
            ['id_estudi' => 10, 'nom' => 'Seguretat en aplicacions',            'estat' => 'actiu'],
            ['id_estudi' => 10, 'nom' => 'IA aplicada',                         'estat' => 'actiu'],
            ['id_estudi' => 10, 'nom' => 'Cloud bàsic',                          'estat' => 'actiu'],

            // DAW 1 (id_estudi=11)
            ['id_estudi' => 11, 'nom' => 'Accesibilitat web',                   'estat' => 'actiu'],
            ['id_estudi' => 11, 'nom' => 'SEO i analítica',                     'estat' => 'actiu'],
            ['id_estudi' => 11, 'nom' => 'JavaScript avançat',                  'estat' => 'actiu'],
            ['id_estudi' => 11, 'nom' => 'Introducció a frameworks frontend',   'estat' => 'actiu'],
            ['id_estudi' => 11, 'nom' => 'Seguretat web bàsica',                'estat' => 'actiu'],

            // DAW 2 (id_estudi=12)
            ['id_estudi' => 12, 'nom' => 'Arquitectura web',                    'estat' => 'actiu'],
            ['id_estudi' => 12, 'nom' => 'Rendiment i optimització',            'estat' => 'actiu'],
            ['id_estudi' => 12, 'nom' => 'Testing end-to-end',                  'estat' => 'actiu'],
            ['id_estudi' => 12, 'nom' => 'Seguretat web avançada',              'estat' => 'actiu'],
            ['id_estudi' => 12, 'nom' => 'Desplegament i monitoratge',          'estat' => 'actiu'],
        ];

        $this->db->table('optativa')->insertBatch($data);
    }
}

