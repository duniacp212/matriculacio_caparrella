<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstudiSeeder extends Seeder
{
    public function run()
    {
        $table = $this->db->table('estudi');

       
        $table->where('tipus !=', 'ESO')->delete();

       
        $cfgm = [
            'CFGM Carrosseria',
            'CFGM Electromecànica de vehicles adaptat a vehicles industrials (camions)',
            'CFGM Electromecànica de vehicles automòbils',
            'CFGM Instal·lacions de Telecomunicacions',
            'CFGM Preimpressió digital',
            'CFGM Sistemes Microinformàtics i Xarxes',
            'CFGM Vídeo, discjòquei i so',
            'CFGM Conducció de vehicles de transport per carretera'
        ];

        foreach ($cfgm as $cicle) {
            for ($i=1; $i<=2; $i++) {
                $table->insert([
                    'id_familia' => 3,
                    'tipus' => $cicle,
                    'nivell' => $i,
                    'estat' => 'actiu',
                    'matricula_viva' => 0
                ]);
            }
        }

      
        $cfgs = [
            'CFGS Administració de sistemes informàtics en xarxa',
            'CFGS Administració de sistemes informàtics en xarxa – perfil ciberseguretat',
            'CFGS Automoció',
            'CFGS Desenvolupament d’Aplicacions Multiplataforma',
            'CFGS Desenvolupament d’Aplicacions Web (dual)',
            'CFGS Disseny i edició de publicacions impreses i multimèdia',
            'CFGS Il·luminació, captació i tractament d’imatge',
            'CFGS Manteniment electrònic'
        ];

        foreach ($cfgs as $cicle) {
            for ($i=1; $i<=2; $i++) {
                $table->insert([
                    'id_familia' => 4,
                    'tipus' => $cicle,
                    'nivell' => $i,
                    'estat' => 'actiu',
                    'matricula_viva' => 0
                ]);
            }
        }

       
        $pfi = [
            'PFI Auxiliar de muntatges d’instal·lacions electrotècniques en edifici',
            'PFI Auxiliar de muntatges d’instal·lacions elèctriques, d\'aigua i gas'
        ];

        foreach ($pfi as $cicle) {
            $table->insert([
                'id_familia' => 5,
                'tipus' => $cicle,
                'nivell' => 1,
                'estat' => 'actiu',
                'matricula_viva' => 0
            ]);
        }

       
        $table->insert([
            'id_familia' => 6,
            'tipus' => 'FP Bàsica Informàtica d’Oficina',
            'nivell' => 1,
            'estat' => 'actiu',
            'matricula_viva' => 0
        ]);

        
        $bat = [
            'Batxillerat Humanitats i ciències socials',
            'Batxillerat Ciències i tecnologia'
        ];

        foreach ($bat as $cicle) {
            for ($i=1; $i<=2; $i++) {
                $table->insert([
                    'id_familia' => 2,
                    'tipus' => $cicle,
                    'nivell' => $i,
                    'estat' => 'actiu',
                    'matricula_viva' => 0
                ]);
            }
        }
    }
}