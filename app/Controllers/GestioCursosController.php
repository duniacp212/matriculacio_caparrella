<?php

namespace App\Controllers;

use App\Models\EstudiModel;

class GestioCursosController extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            redirect()->to('/login')->send();
            exit;
        }
    }

    private function renderCursosPerGrup(string $prefix, string $titol)
    {
        $estudiModel = new EstudiModel();
        $totsCursos = $estudiModel->orderBy('tipus', 'ASC')->orderBy('nivell', 'ASC')->findAll();

        $cursosFiltrats = [];

        foreach ($totsCursos as $curs) {
            $tipus = strtoupper(trim($curs['tipus']));

            $coincideix = false;

            switch ($prefix) {
                case 'ESO':
                    if (str_starts_with($tipus, 'ESO'))
                        $coincideix = true;
                    break;
                case 'BAT':
                    if (str_starts_with($tipus, 'BAT'))
                        $coincideix = true;
                    break;
                case 'CFGM':
                    if (str_starts_with($tipus, 'CFGM'))
                        $coincideix = true;
                    break;
                case 'CFGS':
                    if (str_starts_with($tipus, 'CFGS'))
                        $coincideix = true;
                    break;
                case 'FPB':
                    if (str_starts_with($tipus, 'FPB') || str_starts_with($tipus, 'FP B'))
                        $coincideix = true;
                    break;
                case 'PFI':
                    if (str_starts_with($tipus, 'PFI'))
                        $coincideix = true;
                    break;
            }

            if ($coincideix) {
                // Fetch optativas per a aquest curs si en teníem a OptativaModel, però com he vist estava buit.
                // Usaré la base de dades local per obtenir-les si de cas, però assumim un array buit si no hi ha
                $curs['assignatures'] = [];
                $curs['optatives'] = [];
                
                $db = \Config\Database::connect();
                $curs['assignatures'] = $db->table('assignatura')
                                       ->where('id_estudi', $curs['id_estudi'])
                                       ->get()
                                       ->getResultArray();

                $curs['optatives'] = $db->table('optativa')
                                       ->where('id_estudi', $curs['id_estudi'])
                                       ->get()
                                       ->getResultArray();

                $cursosFiltrats[] = $curs;
            }
        }

        return view('gestio_cursos/index', [
            'title' => $titol,
            'cursos' => $cursosFiltrats
        ]);
    }

    public function eso()
    {
        return $this->renderCursosPerGrup('ESO', 'Gestió de cursos · ESO');
    }

    public function batxillerat()
    {
        return $this->renderCursosPerGrup('BAT', 'Gestió de cursos · Batxillerat');
    }

    public function fpGrauMitja()
    {
        return $this->renderCursosPerGrup('CFGM', 'Gestió de cursos · FP Grau Mitjà');
    }

    public function fpGrauSuperior()
    {
        return $this->renderCursosPerGrup('CFGS', 'Gestió de cursos · FP Grau Superior');
    }

    public function fpBasica()
    {
        return $this->renderCursosPerGrup('FPB', 'Gestió de cursos · FP Bàsica');
    }

    public function pfi()
    {
        return $this->renderCursosPerGrup('PFI', 'Gestió de cursos · PFI');
    }
}
