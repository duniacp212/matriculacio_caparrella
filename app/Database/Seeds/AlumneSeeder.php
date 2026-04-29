<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlumneSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nom' => 'Marc', 'cognom1' => 'Serra', 'cognom2' => 'Pujol', 'data_naixement' => '2008-03-12', 'telefon' => '600111111', 'dni' => '12345678A', 'carrer' => 'Carrer Major', 'numero' => '1', 'pis' => null, 'codi_postal' => '25001', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'marc@email.com'],
            ['nom' => 'Anna', 'cognom1' => 'Vidal', 'cognom2' => 'Soler', 'data_naixement' => '2007-06-22', 'telefon' => '600111112', 'dni' => '12345678B', 'carrer' => 'Carrer Major', 'numero' => '2', 'pis' => '1r 1a', 'codi_postal' => '25001', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'anna@email.com'],
            ['nom' => 'Pol', 'cognom1' => 'Roca', 'cognom2' => 'Martí', 'data_naixement' => '2008-01-18', 'telefon' => '600111113', 'dni' => '12345678C', 'carrer' => 'Carrer Major', 'numero' => '3', 'pis' => '2n 2a', 'codi_postal' => '25002', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Barcelona', 'email' => 'pol@email.com'],
            ['nom' => 'Laia', 'cognom1' => 'Costa', 'cognom2' => 'Riera', 'data_naixement' => '2007-11-02', 'telefon' => '600111114', 'dni' => '12345678D', 'carrer' => 'Avinguda Catalunya', 'numero' => '10', 'pis' => null, 'codi_postal' => '25003', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'laia@email.com'],
            ['nom' => 'Jordi', 'cognom1' => 'Font', 'cognom2' => 'Mas', 'data_naixement' => '2008-04-09', 'telefon' => '600111115', 'dni' => '12345678E', 'carrer' => 'Carrer Sant Joan', 'numero' => '5', 'pis' => '3r 1a', 'codi_postal' => '25004', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'jordi@email.com'],
            ['nom' => 'Clara', 'cognom1' => 'Casas', 'cognom2' => 'Serra', 'data_naixement' => '2007-07-15', 'telefon' => '600111116', 'dni' => '12345678F', 'carrer' => 'Carrer Balmes', 'numero' => '6', 'pis' => null, 'codi_postal' => '25005', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Tarragona', 'email' => 'clara@email.com'],
            ['nom' => 'Nil', 'cognom1' => 'Prat', 'cognom2' => 'Bosch', 'data_naixement' => '2008-02-27', 'telefon' => '600111117', 'dni' => '12345678G', 'carrer' => 'Carrer Urgell', 'numero' => '7', 'pis' => '1r 2a', 'codi_postal' => '25001', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'nil@email.com'],
            ['nom' => 'Paula', 'cognom1' => 'Pons', 'cognom2' => 'Vila', 'data_naixement' => '2007-09-30', 'telefon' => '600111118', 'dni' => '12345678H', 'carrer' => 'Carrer Lleida', 'numero' => '8', 'pis' => null, 'codi_postal' => '25002', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'paula@email.com'],
            ['nom' => 'Hugo', 'cognom1' => 'Navarro', 'cognom2' => 'Sanz', 'data_naixement' => '2008-05-05', 'telefon' => '600111119', 'dni' => '12345678I', 'carrer' => 'Carrer Riu', 'numero' => '9', 'pis' => '2n 1a', 'codi_postal' => '25003', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Madrid', 'email' => 'hugo@email.com'],
            ['nom' => 'Irene', 'cognom1' => 'Gil', 'cognom2' => 'Costa', 'data_naixement' => '2007-12-11', 'telefon' => '600111120', 'dni' => '12345678J', 'carrer' => 'Carrer Pau', 'numero' => '10', 'pis' => null, 'codi_postal' => '25004', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'irene@email.com'],
            ['nom' => 'Eric', 'cognom1' => 'Soler', 'cognom2' => 'Ferrer', 'data_naixement' => '2008-03-21', 'telefon' => '600111121', 'dni' => '12345678K', 'carrer' => 'Carrer Nova', 'numero' => '11', 'pis' => '1r 1a', 'codi_postal' => '25005', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'eric@email.com'],
            ['nom' => 'Marta', 'cognom1' => 'Duran', 'cognom2' => 'Pujol', 'data_naixement' => '2007-08-17', 'telefon' => '600111122', 'dni' => '12345678L', 'carrer' => 'Carrer Vella', 'numero' => '12', 'pis' => null, 'codi_postal' => '25001', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'marta@email.com'],
            ['nom' => 'Adrià', 'cognom1' => 'Serra', 'cognom2' => 'Costa', 'data_naixement' => '2008-06-03', 'telefon' => '600111123', 'dni' => '12345678M', 'carrer' => 'Carrer Alta', 'numero' => '13', 'pis' => '3r 2a', 'codi_postal' => '25002', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'adria@email.com'],
            ['nom' => 'Júlia', 'cognom1' => 'Ribas', 'cognom2' => 'Martí', 'data_naixement' => '2007-10-09', 'telefon' => '600111124', 'dni' => '12345678N', 'carrer' => 'Carrer Baixa', 'numero' => '14', 'pis' => null, 'codi_postal' => '25003', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'julia@email.com'],
            ['nom' => 'David', 'cognom1' => 'Casals', 'cognom2' => 'Roca', 'data_naixement' => '2008-01-25', 'telefon' => '600111125', 'dni' => '12345678O', 'carrer' => 'Carrer Centre', 'numero' => '15', 'pis' => '1r 1a', 'codi_postal' => '25004', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'david@email.com'],
            ['nom' => 'Dunia', 'cognom1' => 'Cañas', 'cognom2' => 'Puig', 'data_naixement' => '2008-01-25', 'telefon' => '600111126', 'dni' => '12345678X', 'carrer' => 'Carrer Centre', 'numero' => '16', 'pis' => null, 'codi_postal' => '25004', 'poblacio' => 'Lleida', 'nacionalitat' => 'Espanyola', 'lloc_naixement' => 'Lleida', 'email' => 'dunia_2121@hotmail.com'],
        ];

        $model = new \App\Models\AlumneModel();

        foreach ($data as $dades) {
            $existent = $model->where('dni', $dades['dni'])->first();
            if (!$existent) {
                // AlumneModel ja generarà el UUID v7 gràcies al callback
                $model->save($dades);
            }
        }
    }
}