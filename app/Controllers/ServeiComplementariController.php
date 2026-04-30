<?php

namespace App\Controllers;

use App\Models\ServeiComplementariModel;

class ServeiComplementariController extends BaseController
{

    public function index()
    {
        $model = new ServeiComplementariModel();

        return view('serveis/index', [
            'title' => 'Gestió de serveis complementaris',
            'serveis' => $model->findAll()
        ]);
    }

    public function guardar()
    {
        $model = new ServeiComplementariModel();
        $preus = $this->request->getPost('preu') ?? [];
        $estats = $this->request->getPost('estat') ?? [];

        foreach ($preus as $id => $preu) {
            $model->update($id, [
                'preu' => $preu,
                'estat' => $estats[$id] ?? null,
            ]);
        }

        return redirect()->to(base_url('serveis'))
            ->with('exit', 'Serveis actualitzats correctament.');
    }

    public function nou()
    {
        return view('serveis/form', [
            'title' => 'Nou servei complementari',
            'servei' => null,
            'url' => base_url('serveis/crear')
        ]);
    }

    public function crear()
    {
        $rules = [
            'tipus' => 'required|min_length[2]|max_length[100]',
            'preu' => 'permit_empty|decimal|greater_than_equal_to[0]',
            'estat' => 'required|in_list[actiu,inactiu]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ServeiComplementariModel();

        $model->insert([
            'tipus' => $this->request->getPost('tipus'),
            'estat' => $this->request->getPost('estat'),
            'preu' => $this->request->getPost('preu'),
        ]);

        return redirect()->to(base_url('serveis'))
            ->with('exit', 'Servei creat correctament.');
    }

    public function eliminar($id)
    {
        $id = (int) $id;
        $model = new ServeiComplementariModel();
        $model->delete($id);

        return redirect()->to(base_url('serveis'))
            ->with('exit', 'Servei eliminat correctament.');
    }
}
