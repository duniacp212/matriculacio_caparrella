<?php

namespace App\Controllers;

use App\Models\AlumneModel;

class MatriculesController extends BaseController
{
    private function carregarTorn(int $torn)
    {
        $request = service('request');

        $filtres = [
            'any'         => $request->getGet('any'),
            'estudi'      => $request->getGet('estudi'),
            'curs'        => $request->getGet('curs'),
            'familia'     => $request->getGet('familia'),
            'cicle'       => $request->getGet('cicle'),
            'estat'       => $request->getGet('estat'),
            'pagament'    => $request->getGet('pagament'),
            'bonificats'  => $request->getGet('bonificacio'),
            'torn'        => $torn,
        ];

        $model = new AlumneModel();
        $alumnes = $model->getAlumnesAmbMatricula($filtres);

        return view('matricules/torn', [
            'title'   => 'Matrícules - ' . $torn . 'r Torn',
            'alumnes' => $alumnes,
            'filtres' => $filtres,
            'torn'    => $torn
        ]);
    }

    public function torn1()
    {
        return $this->carregarTorn(1);
    }

    public function torn2()
    {
        return $this->carregarTorn(2);
    }

    public function torn3()
    {
        return $this->carregarTorn(3);
    }
}
