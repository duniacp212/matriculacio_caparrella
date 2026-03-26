<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class UsuarisController extends BaseController
{
    public function index()
    {
        $model = new UsuariModel();
        $data = [
            'title' => 'Gestió d\'Usuaris Administratius',
            'usuaris' => $model->findAll()
        ];
        return view('usuaris/index', $data);
    }

    public function nou()
    {
        $data = [
            'title' => 'Nou Usuari',
            'usuari' => new \App\Entities\Usuari(),
            'url' => base_url('usuaris/guardar')
        ];
        return view('usuaris/form', $data);
    }

    public function guardar()
    {
        $model = new UsuariModel();
        $usuari = new \App\Entities\Usuari();
        
        $password = $this->request->getPost('password');
        $repetir = $this->request->getPost('repetir_password');

        if ($password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $usuari->nom = $this->request->getPost('nom');
        $usuari->cognom1 = $this->request->getPost('cognom1');
        $usuari->cognom2 = $this->request->getPost('cognom2');
        $usuari->dni_nie = $this->request->getPost('dni_nie');
        $usuari->usuari = $this->request->getPost('usuari');
        $usuari->rol = $this->request->getPost('rol');
        $usuari->password = $password;

        $model->save($usuari);
        return redirect()->to('/usuaris')->with('exit', 'Usuari creat correctament.');
    }

    public function editar($id)
    {
        $model = new UsuariModel();
        $usuari = $model->find($id);

        $data = [
            'title' => 'Editar Usuari',
            'usuari' => $usuari,
            'url' => base_url('usuaris/actualitzar/' . $id)
        ];
        return view('usuaris/form', $data);
    }

    public function actualitzar($id)
    {
        $model = new UsuariModel();
        $usuari = $model->find($id);
        
        $password = $this->request->getPost('password');
        $repetir = $this->request->getPost('repetir_password');

        if (!empty($password) && $password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $usuari->nom = $this->request->getPost('nom');
        $usuari->cognom1 = $this->request->getPost('cognom1');
        $usuari->cognom2 = $this->request->getPost('cognom2');
        $usuari->dni_nie = $this->request->getPost('dni_nie');
        $usuari->usuari = $this->request->getPost('usuari');
        $usuari->rol = $this->request->getPost('rol');
        
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
