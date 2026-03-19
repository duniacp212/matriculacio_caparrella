<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('usuari')->truncate();

        // Password: admin123  (bcrypt hash)
        // Per generar un nou hash: password_hash('admin123', PASSWORD_BCRYPT)
        $data = [
            [
                'id_usuari'  => 1,
                'usuari'     => 'admin',
                'password'   => '$2y$10$PcCjxsaCz23f.U8lyX58c.3MUfHvF37HrS4k7qe5G4JaqcEuuTQXG',
                'rol'        => 'admin',
                'created_at' => '2026-03-10 19:18:53',
            ],
        ];

        $this->db->table('usuari')->insertBatch($data);
    }
}