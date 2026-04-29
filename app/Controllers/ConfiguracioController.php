<?php

namespace App\Controllers;

use App\Models\SettingsModel;

class ConfiguracioController extends BaseController
{
    public function __construct()
    {
        if (session()->get('rol') !== 'super admin') {
            return redirect()->to('/alumnes')->with('error', 'No tens permisos per accedir a aquesta secció.')->send();
        }
    }
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
            'menu_calendari',
            'menu_serveis_complementaris',
            'menu_bonificacions',
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
            
            $existing = $model->where('clau', $key)->first();
            if ($existing) {
                $model->where('clau', $key)->set(['valor' => $value])->update();
            } else {
                $model->insert(['clau' => $key, 'valor' => $value]);
            }
        }

        return redirect()->to('/configuracio')->with('exit', 'Configuració desada correctament.');
    }
}
