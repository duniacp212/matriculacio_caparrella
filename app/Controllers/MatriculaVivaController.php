<?php

namespace App\Controllers;

use App\Models\EstudiModel;

class MatriculaVivaController extends BaseController
{
    public function index()
    {
        $model = new EstudiModel();

        return view('matricula_viva/index', [
            'title'   => 'Activació de matrícula',
            'estudis' => $model->obtenirTots()
        ]);
    }

    public function guardar()
    {
        $model = new EstudiModel();

        $estudisSeleccionats = $this->request->getPost('estudis') ?? [];

        $model->actualitzarMatriculaViva($estudisSeleccionats);

        return redirect()->to(base_url('matricula-viva'))
            ->with('missatge', 'Canvis guardats correctament.');
    }
}
