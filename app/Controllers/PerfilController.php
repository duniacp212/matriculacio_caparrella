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
        if (!$idUsuari) return redirect()->to(base_url('login'));

        try {
            $binaryId = (strlen($idUsuari) === 16) ? $idUsuari : hex2bin(str_replace('-', '', $idUsuari));
        } catch (\Exception $e) {
            return redirect()->to(base_url('login'));
        }

        $model  = new UsuariModel();
        $usuari = $model->find($binaryId);

        if (!$usuari) {
            return redirect()->to(base_url('login'));
        }

        $contrasenya = $this->request->getPost('contrasenya');
        $repetir     = $this->request->getPost('repetir_contrasenya');

        if (empty($contrasenya)) {
            return redirect()->to(base_url('perfil'));
        }

        $rules = [
            'contrasenya' => 'min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]'
        ];

        $missatges = [
            'contrasenya' => [
                'regex_match' => 'La contrasenya ha de contenir almenys una majúscula, un número i un símbol.',
                'min_length'  => 'La contrasenya ha de tenir almenys 8 caràcters.'
            ]
        ];

        if (! $this->validate($rules, $missatges)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($contrasenya !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $antiga = $this->request->getPost('contrasenya_antiga');
        if (empty($antiga) || !password_verify($antiga, $usuari->password)) {
            return redirect()->back()->withInput()->with('error', 'La contrasenya antiga no és correcta.');
        }

        $usuari->password = $contrasenya;

        if ($usuari->hasChanged()) {
            $model->save($usuari);
        }
        
        return redirect()->to(base_url('perfil'))->with('exit', 'Contrasenya actualitzada correctament.');
    }
}
