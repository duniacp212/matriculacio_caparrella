<?php

namespace App\Controllers;

use App\Models\SettingsModel;

class ConfiguracioController extends BaseController
{
    public function index()
    {
        $model = new SettingsModel();
        $data = [
            'title' => 'Configuració de la Interfície',
            'config' => $model->getSettings()
        ];
        return view('configuracio/index', $data);
    }

    public function guardar()
    {
        $model = new SettingsModel();
        $configs = $this->request->getPost('config');

        $allKeys = [
            'menu_alumnes_matriculats',
            'menu_gestio_cursos',
            'menu_matricula_viva',
            'menu_usuaris',
            'filtre_any',
            'filtre_estudi',
            'filtre_curs',
            'filtre_torn',
            'filtre_estat',
            'filtre_pagament',
            'filtre_bonificacio'
        ];

        foreach ($allKeys as $key) {
            $value = isset($configs[$key]) ? 1 : 0;
            $model->where('clau', $key)->set(['valor' => $value])->update();
        }

        return redirect()->to('/configuracio');
    }
}
