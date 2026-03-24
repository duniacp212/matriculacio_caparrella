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
            e.nivell,
            b.tipus as bonificacio_nom,
            b.percentatge as bonificacio_percentatge
        ')
        ->from('matricula m')
        ->join('alumne a', 'a.id_alumne = m.id_alumne')
        ->join('estudi e', 'e.id_estudi = m.id_estudi')
        ->join('matricula_bonificacio mb', 'mb.id_matricula = m.id_matricula', 'left')
        ->join('bonificacio b', 'b.id_bonificacio = mb.id_bonificacio', 'left')
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