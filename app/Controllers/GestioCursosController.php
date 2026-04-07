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

    public function processarAccio()
    {
        $accio = $this->request->getPost('accio');
        $estudiModel = new EstudiModel();
        $db = \Config\Database::connect();

        $cursosIds = $this->request->getPost('cursos') ?? [];
        $assignaturesIds = $this->request->getPost('assignatures') ?? [];
        $optativesIds = $this->request->getPost('optatives') ?? [];

        if ($accio === 'duplicar') {
            foreach ($cursosIds as $id) {
                $estudiModel->duplicarComplet($id);
            }

            foreach ($assignaturesIds as $id) {
                $original = $db->table('assignatura')->where('id_assignatura', $id)->get()->getRowArray();
                if ($original) {
                    unset($original['id_assignatura']);
                    $original['nom'] .= " (Còpia)";
                    $db->table('assignatura')->insert($original);
                }
            }

            foreach ($optativesIds as $id) {
                $original = $db->table('optativa')->where('id_optativa', $id)->get()->getRowArray();
                if ($original) {
                    unset($original['id_optativa']);
                    $original['nom'] .= " (Còpia)";
                    $db->table('optativa')->insert($original);
                }
            }
        }

        if ($accio === 'eliminar') {
            if (!empty($cursosIds)) {
                $estudiModel->delete($cursosIds);
            }
            if (!empty($assignaturesIds)) {
                $db->table('assignatura')->whereIn('id_assignatura', $assignaturesIds)->delete();
            }
            if (!empty($optativesIds)) {
                $db->table('optativa')->whereIn('id_optativa', $optativesIds)->delete();
            }
        }

        return redirect()->back();
    }

    public function nouCurs($tipus = '')
    {
        $tipusNet = strtoupper(str_replace(['fp-gm', 'fp-gs', 'batxillerat'], ['CFGM', 'CFGS', 'BAT'], $tipus));

        return view('gestio_cursos/crear', [
            'title' => 'Afegir nou curs',
            'tipusAuto' => $tipusNet
        ]);
    }

    public function guardarCurs()
    {
        $estudiModel = new EstudiModel();

        $tipusEntrada = $this->request->getPost('tipus');
        $prefix = $this->request->getPost('tipus_prefix');
        $nomCicle = $this->request->getPost('tipus_nom');

        $tipusFinal = !empty($tipusEntrada) ? $tipusEntrada : $prefix . $nomCicle;

        $dadesCurs = [
            'nivell' => $this->request->getPost('nivell'),
            'tipus' => $tipusFinal,
            'matricula_viva' => 1
        ];

        $assignatures = $this->request->getPost('assignatures') ?? [];
        $optatives = $this->request->getPost('optatives') ?? [];

        $estudiModel->crearAmbAssignatures($dadesCurs, $assignatures, $optatives);

        $urlRetorn = 'eso';
        if (str_contains($tipusFinal, 'BAT'))
            $urlRetorn = 'batxillerat';
        if (str_contains($tipusFinal, 'CFGM'))
            $urlRetorn = 'fp-gm';
        if (str_contains($tipusFinal, 'CFGS'))
            $urlRetorn = 'fp-gs';
        if (str_contains($tipusFinal, 'FPB'))
            $urlRetorn = 'fp-basica';
        if (str_contains($tipusFinal, 'PFI'))
            $urlRetorn = 'pfi';

        return redirect()->to('gestio/' . $urlRetorn);
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
