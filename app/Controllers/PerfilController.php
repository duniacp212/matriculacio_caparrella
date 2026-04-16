<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class PerfilController extends BaseController
{
    public function index()
    {
        $model  = new UsuariModel();
        $usuari = $model->where('usuari', session()->get('usuari'))->first();

        return view('perfil/index', [
            'title'  => 'El meu perfil',
            'usuari' => $usuari
        ]);
    }

    public function actualitzar()
    {
        $model  = new UsuariModel();
        $usuari = $model->where('usuari', session()->get('usuari'))->first();

        $password = $this->request->getPost('password');
        $repetir  = $this->request->getPost('repetir_password');

        if (!empty($password) && $password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $dades = [
            'id_usuari' => $usuari->id_usuari,
            'usuari'    => $this->request->getPost('usuari'),
        ];

        if (!empty($password)) {
            $dades['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($usuari->id_usuari, $dades);
        return redirect()->to('/perfil')->with('exit', 'Perfil actualitzat correctament.');
    }
}
