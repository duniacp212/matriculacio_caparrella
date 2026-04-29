<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class AutenticacioController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function autenticacio()
    {
        $session = session();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UsuariModel();

        $usuari = $model->groupStart()
                        ->where('usuari', $username)
                        ->orWhere('email', $username)
                        ->groupEnd()
                        ->first();

        if ($usuari && password_verify($password, $usuari->password)) {

            $nomComplet = $usuari->nom . ' ' . $usuari->cognom1 . ($usuari->cognom2 ? ' ' . $usuari->cognom2 : '');
            
            $session->set([
                'logged_in'   => true,
                'id_usuari'   => $usuari->id_usuari,
                'nom_complet' => $nomComplet,
                'rol'         => $usuari->rol
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