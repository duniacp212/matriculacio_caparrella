<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class UsuarisController extends BaseController
{
    public function index()
    {
        $model = new UsuariModel();
        $data = [
            'title'   => 'Gestió d\'Usuaris Administratius',
            'usuaris' => $model->findAll()
        ];
        return view('usuaris/index', $data);
    }

    public function nou()
    {
        $data = [
            'title'  => 'Nou Usuari',
            'usuari' => new \App\Entities\Usuari(),
            'url'    => base_url('usuaris/guardar')
        ];
        return view('usuaris/form', $data);
    }

    public function guardar()
    {
        $model = new UsuariModel();

        $rules = [
            'nom'      => 'required|min_length[2]|max_length[100]',
            'cognom1'  => 'required|min_length[2]|max_length[100]',
            'cognom2'  => 'permit_empty|max_length[100]',
            'dni_nie'  => 'required|max_length[20]|is_unique[usuari.dni_nie]|dni_nie_valid',
            'usuari'   => 'required|min_length[3]|max_length[100]|is_unique[usuari.usuari]',
            'password' => 'required|min_length[6]',
            'rol'      => 'required|in_list[super admin,administracio,secretaria]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $password = $this->request->getPost('password');
        $repetir  = $this->request->getPost('repetir_password');

        if ($password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $usuari           = new \App\Entities\Usuari();
        $usuari->nom      = $this->request->getPost('nom');
        $usuari->cognom1  = $this->request->getPost('cognom1');
        $usuari->cognom2  = $this->request->getPost('cognom2');
        $usuari->dni_nie  = $this->request->getPost('dni_nie');
        $usuari->usuari   = $this->request->getPost('usuari');
        $usuari->rol      = $this->request->getPost('rol');
        $usuari->password = $password;

        $model->save($usuari);
        return redirect()->to('/usuaris')->with('exit', 'Usuari creat correctament.');
    }

    public function editar($id)
    {
        $id    = (int) $id;
        $model  = new UsuariModel();
        $usuari = $model->find($id);

        $data = [
            'title'  => 'Editar Usuari',
            'usuari' => $usuari,
            'url'    => base_url('usuaris/actualitzar/' . $id)
        ];
        return view('usuaris/form', $data);
    }

    public function actualitzar($id)
    {
        $id     = (int) $id;
        $model  = new UsuariModel();
        $usuari = $model->find($id);

        $rules = [
            'nom'     => 'required|min_length[2]|max_length[100]',
            'cognom1' => 'required|min_length[2]|max_length[100]',
            'cognom2' => 'permit_empty|max_length[100]',
            'dni_nie' => 'required|max_length[20]|is_unique[usuari.dni_nie,id_usuari,' . $id . ']|dni_nie_valid',
            'usuari'  => 'required|min_length[3]|max_length[100]|is_unique[usuari.usuari,id_usuari,' . $id . ']',
            'rol'     => 'required|in_list[super admin,administracio,secretaria]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $password = $this->request->getPost('password');
        $repetir  = $this->request->getPost('repetir_password');

        if (!empty($password) && $password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $usuari->nom     = $this->request->getPost('nom');
        $usuari->cognom1 = $this->request->getPost('cognom1');
        $usuari->cognom2 = $this->request->getPost('cognom2');
        $usuari->dni_nie = $this->request->getPost('dni_nie');
        $usuari->usuari  = $this->request->getPost('usuari');
        $usuari->rol     = $this->request->getPost('rol');

        if (!empty($password)) {
            $usuari->password = $password;
        }

        $model->save($usuari);
        return redirect()->to('/usuaris')->with('exit', 'Usuari actualitzat correctament.');
    }

    public function eliminar($id)
    {
        $model = new UsuariModel();
        $model->delete($id);
        return redirect()->to('/usuaris');
    }
}