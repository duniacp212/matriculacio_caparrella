<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class PerfilController extends BaseController
{
    public function index()
    {
        $idUsuari = session()->get('id_usuari');
        
        if (!$idUsuari) {
            return redirect()->to('/login');
        }

        try {
            $binaryId = (strlen($idUsuari) === 16) ? $idUsuari : hex2bin(str_replace('-', '', $idUsuari));
        } catch (\Exception $e) {
            return redirect()->to('/login')->with('error', 'Sessió no vàlida.');
        }

        $model  = new UsuariModel();
        $usuari = $model->find($binaryId);

        if (!$usuari) {
            return redirect()->to('/login')->with('error', 'Usuari no trobat.');
        }

        return view('perfil/index', [
            'title'  => 'El meu perfil',
            'usuari' => $usuari
        ]);
    }

    public function actualitzar()
    {
        $idUsuari = session()->get('id_usuari');
        if (!$idUsuari) return redirect()->to('/login');

        try {
            $binaryId = (strlen($idUsuari) === 16) ? $idUsuari : hex2bin(str_replace('-', '', $idUsuari));
        } catch (\Exception $e) {
            return redirect()->to('/login');
        }

        $model  = new UsuariModel();
        $usuari = $model->find($binaryId);

        if (!$usuari) {
            return redirect()->to('/login');
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $repetir  = $this->request->getPost('repetir_password');

        

        $rules = [
            'email'   => 'required|valid_email',
            'telefon' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($email !== $usuari->email) {
            $existent = $model->where('email', $email)->first();
            if ($existent) {
                return redirect()->back()->withInput()->with('error', 'Aquest correu electrònic ja està en ús.');
            }
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
