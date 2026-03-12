<?php

namespace App\Controllers;

use App\Models\MatriculaModel;

class MatriculesController extends BaseController
{

    public function matricula_alumne($id)
    {
        $model = new MatriculaModel();

        $matricula = $model->select('
            m.id_matricula,
            m.data,
            m.data_pagament,
            m.estat,
            m.torn,
            m.observacions,
            a.nom,
            a.cognom1,
            a.cognom2,
            a.dni,
            e.tipus,
            e.nivell
        ')
        ->from('matricula m')
        ->join('alumne a', 'a.id_alumne = m.id_alumne')
        ->join('estudi e', 'e.id_estudi = m.id_estudi')
        ->where('m.id_matricula', $id)
        ->first();

        if (!$matricula) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Matrícula no trobada');
        }

        return view('matricules/matricula_alumne', [
            'title' => 'Dades de la matrícula',
            'matricula' => $matricula
        ]);
    }

}