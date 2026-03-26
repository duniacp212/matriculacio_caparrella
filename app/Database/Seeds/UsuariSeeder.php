<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariSeeder extends Seeder
{
    public function run()
    {
        $model = new \App\Models\UsuariModel();
        
        if (!$model->where('usuari', 'admin')->first()) {
            $usuari = new \App\Entities\Usuari();
            $usuari->nom = 'Administrador';
            $usuari->cognom1 = 'del';
            $usuari->cognom2 = 'Sistema';
            $usuari->dni_nie = '00000000X';
            $usuari->usuari = 'admin';
            $usuari->password = 'admin123';
            $usuari->rol = 'super admin';

            $model->save($usuari);
        }
    }
}