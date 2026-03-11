<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'usuari' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'rol' => 'admin'
        ];

        $this->db->table('usuari')->insert($data);
    }
}