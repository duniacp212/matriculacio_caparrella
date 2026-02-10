<?php

namespace App\Controllers;

use App\Models\MatriculaModel;

class MatriculesController extends BaseController
{
    public function torn1()
    {
        $request = service('request');

        $filtres = [
            'any_matricula' => $request->getGet('any'),
            'estudi'        => $request->getGet('estudi'),
            'curs'          => $request->getGet('curs'),
            'familia'       => $request->getGet('familia'),
            'cicle'         => $request->getGet('cicle'),
            'estat'         => $request->getGet('estat'),
            'pagament'      => $request->getGet('pagament'),
        ];

        $model = new MatriculaModel();
        $alumnes = $model->obtenirAlumnesAmbFiltres($filtres);

        return view('matricules/torn1', [
            'title'   => 'Matrícules - 1r Torn',
            'alumnes' => $alumnes,
            'filtres' => $filtres
        ]);
        
    }

    public function torn2()
    {
        $request = service('request');

        $filtres = [
            'any_matricula' => $request->getGet('any'),
            'estudi'        => $request->getGet('estudi'),
            'curs'          => $request->getGet('curs'),
            'familia'       => $request->getGet('familia'),
            'cicle'         => $request->getGet('cicle'),
            'estat'         => $request->getGet('estat'),
            'pagament'      => $request->getGet('pagament'),
        ];

        $model = new MatriculaModel();
        $alumnes = $model->obtenirAlumnesAmbFiltres($filtres);

        return view('matricules/torn2', [
            'title'   => 'Matrícules - 2n Torn',
            'alumnes' => $alumnes,
            'filtres' => $filtres
        ]);
        
    }
}
