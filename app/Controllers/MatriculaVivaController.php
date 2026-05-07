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
            $estudiActual = $model->find($id);
            $novesPlaces = ($places[$id] !== '' && $places[$id] !== null) ? $places[$id] : null;

            $dades = [
                'matricula_viva' => $valor,
                'places' => $novesPlaces,
            ];

            if ($novesPlaces !== null && $estudiActual['data_viva'] === null) {
                $dades['data_viva'] = date('Y-m-d');
            } elseif ($novesPlaces === null) {
                $dades['data_viva'] = null;
            }

            $model->update($id, $dades);
        }

        return redirect()->to(base_url('matricula-viva'))
            ->with('missatge', 'Canvis guardats correctament.');
    }
}