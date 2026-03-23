<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlumneSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nom' => 'Marc', 'cognom1' => 'Serra', 'cognom2' => 'Pujol', 'data_naixement' => '2008-03-12', 'telefon' => '600111111', 'dni' => '12345678A', 'direccio' => 'Carrer Major 1', 'email' => 'marc@email.com'],
            ['nom' => 'Anna', 'cognom1' => 'Vidal', 'cognom2' => 'Soler', 'data_naixement' => '2007-06-22', 'telefon' => '600111112', 'dni' => '12345678B', 'direccio' => 'Carrer Major 2', 'email' => 'anna@email.com'],
            ['nom' => 'Pol', 'cognom1' => 'Roca', 'cognom2' => 'Martí', 'data_naixement' => '2008-01-18', 'telefon' => '600111113', 'dni' => '12345678C', 'direccio' => 'Carrer Major 3', 'email' => 'pol@email.com'],
            ['nom' => 'Laia', 'cognom1' => 'Costa', 'cognom2' => 'Riera', 'data_naixement' => '2007-11-02', 'telefon' => '600111114', 'dni' => '12345678D', 'direccio' => 'Carrer Major 4', 'email' => 'laia@email.com'],
            ['nom' => 'Jordi', 'cognom1' => 'Font', 'cognom2' => 'Mas', 'data_naixement' => '2008-04-09', 'telefon' => '600111115', 'dni' => '12345678E', 'direccio' => 'Carrer Major 5', 'email' => 'jordi@email.com'],
            ['nom' => 'Clara', 'cognom1' => 'Casas', 'cognom2' => 'Serra', 'data_naixement' => '2007-07-15', 'telefon' => '600111116', 'dni' => '12345678F', 'direccio' => 'Carrer Major 6', 'email' => 'clara@email.com'],
            ['nom' => 'Nil', 'cognom1' => 'Prat', 'cognom2' => 'Bosch', 'data_naixement' => '2008-02-27', 'telefon' => '600111117', 'dni' => '12345678G', 'direccio' => 'Carrer Major 7', 'email' => 'nil@email.com'],
            ['nom' => 'Paula', 'cognom1' => 'Pons', 'cognom2' => 'Vila', 'data_naixement' => '2007-09-30', 'telefon' => '600111118', 'dni' => '12345678H', 'direccio' => 'Carrer Major 8', 'email' => 'paula@email.com'],
            ['nom' => 'Hugo', 'cognom1' => 'Navarro', 'cognom2' => 'Sanz', 'data_naixement' => '2008-05-05', 'telefon' => '600111119', 'dni' => '12345678I', 'direccio' => 'Carrer Major 9', 'email' => 'hugo@email.com'],
            ['nom' => 'Irene', 'cognom1' => 'Gil', 'cognom2' => 'Costa', 'data_naixement' => '2007-12-11', 'telefon' => '600111120', 'dni' => '12345678J', 'direccio' => 'Carrer Major 10', 'email' => 'irene@email.com'],
            ['nom' => 'Eric', 'cognom1' => 'Soler', 'cognom2' => 'Ferrer', 'data_naixement' => '2008-03-21', 'telefon' => '600111121', 'dni' => '12345678K', 'direccio' => 'Carrer Major 11', 'email' => 'eric@email.com'],
            ['nom' => 'Marta', 'cognom1' => 'Duran', 'cognom2' => 'Pujol', 'data_naixement' => '2007-08-17', 'telefon' => '600111122', 'dni' => '12345678L', 'direccio' => 'Carrer Major 12', 'email' => 'marta@email.com'],
            ['nom' => 'Adrià', 'cognom1' => 'Serra', 'cognom2' => 'Costa', 'data_naixement' => '2008-06-03', 'telefon' => '600111123', 'dni' => '12345678M', 'direccio' => 'Carrer Major 13', 'email' => 'adria@email.com'],
            ['nom' => 'Júlia', 'cognom1' => 'Ribas', 'cognom2' => 'Martí', 'data_naixement' => '2007-10-09', 'telefon' => '600111124', 'dni' => '12345678N', 'direccio' => 'Carrer Major 14', 'email' => 'julia@email.com'],
            ['nom' => 'David', 'cognom1' => 'Casals', 'cognom2' => 'Roca', 'data_naixement' => '2008-01-25', 'telefon' => '600111125', 'dni' => '12345678O', 'direccio' => 'Carrer Major 15', 'email' => 'david@email.com'],
        ];

        $this->db->table('alumne')->insertBatch($data);
    }
}