<?php

namespace App\Controllers;

use App\Models\BonificacioModel;

class BonificacionsController extends BaseController
{
    public function __construct()
    {
        if (! in_array(session()->get('rol'), ['super admin', 'administracio'])) {
            return redirect()->to('/alumnes')->with('error', 'No tens permisos per accedir a aquesta secció.')->send();
        }
    }

    public function index()
    {
        $model = new BonificacioModel();

        return view('bonificacions/index', [
            'title'         => 'Gestió de bonificacions',
            'bonificacions' => $model->findAll()
        ]);
    }

    public function guardar()
    {
        $model         = new BonificacioModel();
        $percentatges  = $this->request->getPost('percentatge') ?? [];
        $descripcions  = $this->request->getPost('descripcio') ?? [];

        foreach ($percentatges as $id => $percentatge) {
            $model->update($id, [
                'percentatge' => $percentatge,
                'descripcio'  => $descripcions[$id] ?? '',
            ]);
        }

        return redirect()->to(base_url('bonificacions'))
            ->with('exit', 'Bonificacions actualitzades correctament.');
    }

    public function nou()
    {
        return view('bonificacions/form', [
            'title'       => 'Nova bonificació',
            'bonificacio' => null,
            'url'         => base_url('bonificacions/crear')
        ]);
    }

    public function crear()
    {
        $rules = [
            'tipus'       => 'required|min_length[2]|max_length[100]',
            'percentatge' => 'required|numeric|less_than_equal_to[100]|greater_than_equal_to[0]',
            'descripcio'  => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new BonificacioModel();

        $model->insert([
            'tipus'       => $this->request->getPost('tipus'),
            'descripcio'  => $this->request->getPost('descripcio'),
            'percentatge' => $this->request->getPost('percentatge'),
        ]);

        return redirect()->to(base_url('bonificacions'))
            ->with('exit', 'Bonificació creada correctament.');
    }

    public function eliminar($id)
    {
        $id    = (int) $id;
        $model = new BonificacioModel();
        $model->delete($id);

        return redirect()->to(base_url('bonificacions'))
            ->with('exit', 'Bonificació eliminada correctament.');
    }
}
