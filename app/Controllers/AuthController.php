<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        $session = session();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UsuariModel();

        $usuari = $model->where('usuari', $username)->first();

        if ($usuari && password_verify($password, $usuari['password'])) {

            $session->set([
                'logged_in' => true,
                'usuari' => $usuari['usuari'],
                'rol' => $usuari['rol']
            ]);

            return redirect()->to('/alumnes');
        }

        return redirect()->back()->with('error', 'Usuari o contrasenya incorrectes');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}