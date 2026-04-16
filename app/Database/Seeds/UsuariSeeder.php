<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariSeeder extends Seeder
{
    public function run()
    {
        $model = new \App\Models\UsuariModel();

        $usuaris = [
            [
                'nom'      => 'Super',
                'cognom1'  => 'Admin',
                'cognom2'  => null,
                'dni_nie'  => '42496312V',
                'usuari'   => 'superadmin',
                'password' => '123456',
                'rol'      => 'super admin',
            ],
            [
                'nom'      => 'Admin',
                'cognom1'  => 'Admin',
                'cognom2'  => null,
                'dni_nie'  => '90757703W',
                'usuari'   => 'admin',
                'password' => '123456',
                'rol'      => 'administracio',
            ],
            [
                'nom'      => 'Secretaria',
                'cognom1'  => 'Secretaria',
                'cognom2'  => null,
                'dni_nie'  => '60587472K',
                'usuari'   => 'secretaria',
                'password' => '123456',
                'rol'      => 'secretaria',
            ],
        ];

        foreach ($usuaris as $dades) {
            if (!$model->where('usuari', $dades['usuari'])->first()) {
                $usuari           = new \App\Entities\Usuari();
                $usuari->nom      = $dades['nom'];
                $usuari->cognom1  = $dades['cognom1'];
                $usuari->cognom2  = $dades['cognom2'];
                $usuari->dni_nie  = $dades['dni_nie'];
                $usuari->usuari   = $dades['usuari'];
                $usuari->password = $dades['password'];
                $usuari->rol      = $dades['rol'];

                $model->save($usuari);
            }
        }
    }
}
