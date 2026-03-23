<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('FamiliaSeeder');
        $this->call('EstudiSeeder');
        $this->call('AssignaturaSeeder');
        $this->call('UsuariSeeder');
    }
}
