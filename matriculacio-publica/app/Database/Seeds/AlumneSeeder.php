<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlumneSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('alumne')->truncate();

        $data = [
            ['id_alumne' =>  1, 'nom' => 'Marc',   'cognom1' => 'Serra',   'cognom2' => 'Pujol',  'data_naixement' => '2008-03-12', 'telefon' => '600111111', 'dni' => '12345678A', 'direccio' => 'Carrer Major 1',  'email' => 'marc1@email.com',   'expedient' => null],
            ['id_alumne' =>  2, 'nom' => 'Anna',   'cognom1' => 'Vidal',   'cognom2' => 'Soler',  'data_naixement' => '2007-06-22', 'telefon' => '600111112', 'dni' => '12345678B', 'direccio' => 'Carrer Major 2',  'email' => 'anna2@email.com',   'expedient' => null],
            ['id_alumne' =>  3, 'nom' => 'Pol',    'cognom1' => 'Roca',    'cognom2' => 'Martí',  'data_naixement' => '2008-01-18', 'telefon' => '600111113', 'dni' => '12345678C', 'direccio' => 'Carrer Major 3',  'email' => 'pol3@email.com',    'expedient' => null],
            ['id_alumne' =>  4, 'nom' => 'Laia',   'cognom1' => 'Costa',   'cognom2' => 'Riera',  'data_naixement' => '2007-11-02', 'telefon' => '600111114', 'dni' => '12345678D', 'direccio' => 'Carrer Major 4',  'email' => 'laia4@email.com',   'expedient' => null],
            ['id_alumne' =>  5, 'nom' => 'Jordi',  'cognom1' => 'Font',    'cognom2' => 'Mas',    'data_naixement' => '2008-04-09', 'telefon' => '600111115', 'dni' => '12345678E', 'direccio' => 'Carrer Major 5',  'email' => 'jordi5@email.com',  'expedient' => null],
            ['id_alumne' =>  6, 'nom' => 'Clara',  'cognom1' => 'Casas',   'cognom2' => 'Serra',  'data_naixement' => '2007-07-15', 'telefon' => '600111116', 'dni' => '12345678F', 'direccio' => 'Carrer Major 6',  'email' => 'clara6@email.com',  'expedient' => null],
            ['id_alumne' =>  7, 'nom' => 'Nil',    'cognom1' => 'Prat',    'cognom2' => 'Bosch',  'data_naixement' => '2008-02-27', 'telefon' => '600111117', 'dni' => '12345678G', 'direccio' => 'Carrer Major 7',  'email' => 'nil7@email.com',    'expedient' => null],
            ['id_alumne' =>  8, 'nom' => 'Paula',  'cognom1' => 'Pons',    'cognom2' => 'Vila',   'data_naixement' => '2007-09-30', 'telefon' => '600111118', 'dni' => '12345678H', 'direccio' => 'Carrer Major 8',  'email' => 'paula8@email.com',  'expedient' => null],
            ['id_alumne' =>  9, 'nom' => 'Hugo',   'cognom1' => 'Navarro', 'cognom2' => 'Sanz',   'data_naixement' => '2008-05-05', 'telefon' => '600111119', 'dni' => '12345678I', 'direccio' => 'Carrer Major 9',  'email' => 'hugo9@email.com',   'expedient' => null],
            ['id_alumne' => 10, 'nom' => 'Irene',  'cognom1' => 'Gil',     'cognom2' => 'Costa',  'data_naixement' => '2007-12-11', 'telefon' => '600111120', 'dni' => '12345678J', 'direccio' => 'Carrer Major 10', 'email' => 'irene10@email.com', 'expedient' => null],
            ['id_alumne' => 11, 'nom' => 'Eric',   'cognom1' => 'Soler',   'cognom2' => 'Ferrer', 'data_naixement' => '2008-03-21', 'telefon' => '600111121', 'dni' => '12345678K', 'direccio' => 'Carrer Major 11', 'email' => 'eric11@email.com',  'expedient' => null],
            ['id_alumne' => 12, 'nom' => 'Marta',  'cognom1' => 'Duran',   'cognom2' => 'Pujol',  'data_naixement' => '2007-08-17', 'telefon' => '600111122', 'dni' => '12345678L', 'direccio' => 'Carrer Major 12', 'email' => 'marta12@email.com', 'expedient' => null],
            ['id_alumne' => 13, 'nom' => 'Adrià',  'cognom1' => 'Serra',   'cognom2' => 'Costa',  'data_naixement' => '2008-06-03', 'telefon' => '600111123', 'dni' => '12345678M', 'direccio' => 'Carrer Major 13', 'email' => 'adria13@email.com', 'expedient' => null],
            ['id_alumne' => 14, 'nom' => 'Julia',  'cognom1' => 'Ribas',   'cognom2' => 'Martí',  'data_naixement' => '2007-10-09', 'telefon' => '600111124', 'dni' => '12345678N', 'direccio' => 'Carrer Major 14', 'email' => 'julia14@email.com', 'expedient' => null],
            ['id_alumne' => 15, 'nom' => 'David',  'cognom1' => 'Casals',  'cognom2' => 'Roca',   'data_naixement' => '2008-01-25', 'telefon' => '600111125', 'dni' => '12345678O', 'direccio' => 'Carrer Major 15', 'email' => 'david15@email.com', 'expedient' => null],
        ];

        $this->db->table('alumne')->insertBatch($data);
    }
}