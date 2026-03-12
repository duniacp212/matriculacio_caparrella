<?php

namespace App\Controllers;

use App\Models\AlumneModel;
use App\Models\MatriculaModel;
use App\Models\EstudiModel;

class AlumnesController extends BaseController
{
    public function __construct()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            redirect()->to('/login')->send();
            exit;
        }
    }

    public function index()
    {
        $request = service('request');

        $filtres = [
            'any'         => $request->getGet('any'),
            'estudi'      => $request->getGet('estudi'),
            'curs'        => $request->getGet('curs'),
            'torn'        => $request->getGet('torn'),
            'familia'     => $request->getGet('familia'),
            'cicle'       => $request->getGet('cicle'),
            'estat'       => $request->getGet('estat'),
            'pagament'    => $request->getGet('pagament'),
            'bonificats'  => $request->getGet('bonificacio'),
            'cerca'       => $request->getGet('cerca'),
        ];

        $model = new AlumneModel();
        $alumnes = $model->getAlumnesAmbMatricula($filtres);

        $estudiModel = new EstudiModel();
        $cicles = $estudiModel->obtenirCicles();
        $cursos = $estudiModel->obtenirCursos();
        $estudis = $estudiModel->obtenirEstudis();
        $families = $estudiModel->obtenirFamilies();

        return view('alumnes/index', [
            'title'    => 'Alumnes / Expedients',
            'alumnes'  => $alumnes,
            'filtres'  => $filtres,
            'cicles'   => $cicles,
            'cursos'   => $cursos,
            'estudis'  => $estudis,
            'families' => $families
        ]);
    }

    public function resumMatriculats()
    {
        $request = service('request');
        $anySeleccionat = $request->getGet('any');

        $model = new MatriculaModel();
        $files = $model->getResumMatriculats($anySeleccionat);

        $organitzat = [];
        $totalGeneral = 0;

        foreach ($files as $fila) {
            $organitzat[$fila['estudi']][] = $fila;
            $totalGeneral += $fila['total'];
        }

        return view('alumnes/resum_matriculats', [
            'title'        => 'Resum d’alumnes matriculats',
            'dades'        => $organitzat,
            'totalGeneral' => $totalGeneral,
            'anyActual'    => $anySeleccionat
        ]);
    }

    public function cercaGlobal()
    {
        $request = service('request');
        $q = $request->getGet('q');

        $model = new \App\Models\AlumneModel();

        $resultats = [];

        if (!empty($q)) {
            $resultats = $model->cercaGlobal($q);
        }

        return view('alumnes/cerca', [
            'title'     => 'Resultats de la cerca',
            'resultats' => $resultats,
            'q'         => $q
        ]);
    }

    public function contacte(int $id)
    {
        $model = new AlumneModel();
        $alumne = $model->getContactePerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        return view('alumnes/contacte', [
            'title'  => 'Contacte alumne',
            'alumne' => $alumne
        ]);
    }

    public function expedient(int $id)
    {
        $model = new AlumneModel();
        $alumne = $model->getExpedientPerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        return view('alumnes/expedient', [
            'title'  => 'Expedient de l’alumne',
            'alumne' => $alumne
        ]);
    }
}