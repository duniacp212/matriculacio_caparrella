<?php

namespace App\Controllers;

use App\Models\MatriculaModel;

class MatriculesController extends BaseController
{
    public function matricula_alumne($id)
    {
        $id    = (int) $id;
        $model = new MatriculaModel();

        $matricula = $model->getMatriculaAmbDades($id);

        if (!$matricula) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Matrícula no trobada');
        }

        return view('matricules/matricula_alumne', [
            'title'     => 'Dades de la matrícula',
            'matricula' => $matricula
        ]);
    }
}