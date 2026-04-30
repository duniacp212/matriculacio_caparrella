<?php

namespace App\Controllers;

use App\Models\EstudiModel;

class MatriculaVivaController extends BaseController
{

    public function index()
    {
        $model = new EstudiModel();

        return view('matricula_viva/index', [
            'title' => 'Activació de matrícula',
            'estudis' => $model->obtenirTots()
        ]);
    }

    public function guardar()
    {
        $model = new EstudiModel();
        $estats = $this->request->getPost('estat') ?? [];
        $places = $this->request->getPost('places') ?? [];

        foreach ($estats as $id => $valor) {
            $model->update($id, [
                'matricula_viva' => $valor,
                'places' => $places[$id] ?? null,
            ]);
        }

        return redirect()->to(base_url('matricula-viva'))
            ->with('missatge', 'Canvis guardats correctament.');
    }
}