<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class PerfilController extends BaseController
{
    public function index()
    {
        $idUsuari = session()->get('id_usuari');
        $binaryId = hex2bin(str_replace('-', '', $idUsuari));
        $model  = new UsuariModel();
        $usuari = $model->find($binaryId);

        return view('perfil/index', [
            'title'  => 'El meu perfil',
            'usuari' => $usuari
        ]);
    }

    public function actualitzar()
    {
        $idUsuari = session()->get('id_usuari');
        $binaryId = hex2bin(str_replace('-', '', $idUsuari));
        $model  = new UsuariModel();
        $usuari = $model->find($binaryId);

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $repetir  = $this->request->getPost('repetir_password');

        $rules = [
            'email'   => 'required|valid_email|is_unique[usuari.email,id_usuari,' . $binaryId . ']',
            'telefon' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!empty($password) && $password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $usuari->email   = $email;
        $usuari->usuari  = $email;
        $usuari->telefon = $this->request->getPost('telefon');

        if (!empty($password)) {
            $usuari->password = $password;
        }

        if ($usuari->hasChanged()) {
            $model->save($usuari);
        }
        
        return redirect()->to('/perfil')->with('exit', 'Perfil actualitzat correctament.');
    }
}
