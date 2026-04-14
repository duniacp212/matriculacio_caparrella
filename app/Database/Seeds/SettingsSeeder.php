<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['clau' => 'menu_alumnes_matriculats', 'valor' => 1],
            ['clau' => 'menu_gestio_cursos', 'valor' => 1],
            ['clau' => 'menu_matricula_viva', 'valor' => 1],
            ['clau' => 'menu_usuaris', 'valor' => 1],
            ['clau' => 'filtre_any', 'valor' => 1],
            ['clau' => 'filtre_estudi', 'valor' => 1],
            ['clau' => 'filtre_curs', 'valor' => 1],
            ['clau' => 'filtre_torn', 'valor' => 1],
            ['clau' => 'filtre_estat', 'valor' => 1],
            ['clau' => 'filtre_pagament', 'valor' => 1],
            ['clau' => 'filtre_bonificacio', 'valor' => 1],
        ];

        foreach ($data as $d) {
            $exists = $this->db->table('settings')->where('clau', $d['clau'])->get()->getRowArray();
            if (!$exists) {
                $this->db->table('settings')->insert($d);
            }
        }
    }
}