<?php

namespace App\Controllers;

use App\Models\AlumneModel;

class MatriculesController extends BaseController
{
    private function carregarTorn(int $torn)
    {
        $request = service('request');

        $filtres = [
            'any'      => $request->getGet('any'),
            'estudi'   => $request->getGet('estudi'),
            'curs'     => $request->getGet('curs'),
            'familia'  => $request->getGet('familia'),
            'estat'    => $request->getGet('estat'),
            'pagament' => $request->getGet('pagament'),
            'cerca'    => $request->getGet('cerca'),
            'torn'     => $torn
        ];

        $alumneModel = new \App\Models\AlumneModel();
        $alumnes = $alumneModel->getAlumnesAmbMatricula($filtres);

        $matriculaModel = new \App\Models\MatriculaModel();
        $anys = $matriculaModel
            ->select('YEAR(data) as any')
            ->distinct()
            ->orderBy('any', 'DESC')
            ->findAll();

        return view('matricules/torn', [
            'title'   => 'Matrícules - ' . $torn . 'r Torn',
            'alumnes' => $alumnes,
            'filtres' => $filtres,
            'torn'    => $torn,
            'anys'    => $anys
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
