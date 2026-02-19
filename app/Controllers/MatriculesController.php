<?php

namespace App\Controllers;

use App\Models\MatriculaModel;

class MatriculesController extends BaseController
{
    private function carregarTorn(string $torn, string $titol)
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
            'bonificats'    => $request->getGet('bonificacio'),
        ];

        $model = new MatriculaModel();
        $alumnes = $model->obtenirAlumnesAmbFiltres($filtres);

        return view('matricules/' . $torn, [
            'title'   => $titol,
            'alumnes' => $alumnes,
            'filtres' => $filtres
        ]);
    }

    public function torn1()
    {
        return $this->carregarTorn('torn1', 'Matrícules - 1r Torn');
    }

    public function torn2()
    {
        return $this->carregarTorn('torn2', 'Matrícules - 2n Torn');
    }

    public function torn3()
    {
        return $this->carregarTorn('torn3', 'Matrícules - 3r Torn');
    }
}
