<?php

namespace App\Controllers;

use App\Models\EstudiModel;
use App\Models\AssignaturaModel;
use App\Models\OptativaModel;

class GestioCursosController extends BaseController
{
    public function __construct()
    {
        if (! in_array(session()->get('rol'), ['super admin', 'administracio'])) {
            return redirect()->to('/alumnes')->with('error', 'No tens permisos per accedir a aquesta secció.')->send();
        }
    }

    public function processarAccio()
    {
        $accio = $this->request->getPost('accio');
        $estudiModel = new EstudiModel();
        $assignaturaModel = new AssignaturaModel();
        $optativaModel = new OptativaModel();

        $cursosIds = $this->request->getPost('cursos') ?? [];
        $assignaturesIds = $this->request->getPost('assignatures') ?? [];
        $optativesIds = $this->request->getPost('optatives') ?? [];

        if ($accio === 'duplicar') {
            foreach ($cursosIds as $id) {
                $estudiModel->duplicarComplet($id);
            }

            foreach ($assignaturesIds as $id) {
                $original = $assignaturaModel->find($id);
                if ($original) {
                    unset($original['id_assignatura']);
                    $original['nom'] .= " (Còpia)";
                    $assignaturaModel->insert($original);
                }
            }

            foreach ($optativesIds as $id) {
                $original = $optativaModel->find($id);
                if ($original) {
                    unset($original['id_optativa']);
                    $original['nom'] .= " (Còpia)";
                    $optativaModel->insert($original);
                }
            }
        }

        if ($accio === 'eliminar') {
            if (!empty($cursosIds)) {
                $estudiModel->delete($cursosIds);
            }
            if (!empty($assignaturesIds)) {
                $assignaturaModel->delete($assignaturesIds);
            }
            if (!empty($optativesIds)) {
                $optativaModel->delete($optativesIds);
            }
        }

        if ($accio === 'editar') {
            if (empty($cursosIds)) {
                return redirect()->back()->with('error', 'Selecciona almenys un curs per editar.');
            }
            return redirect()->to('gestio/editar-curs/' . $cursosIds[0]);
        }

        return redirect()->back();
    }

    public function nouCurs($tipus = '')
    {
        $tipusNet = strtoupper(str_replace(['fp-gm', 'fp-gs', 'batxillerat'], ['CFGM', 'CFGS', 'BATXILLERAT'], $tipus));

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
        $idFamilia = $this->request->getPost('id_familia') ?? 1;

        $tipusFinal = !empty($nomCicle) ? $prefix . $nomCicle : $tipusEntrada;

        $dadesCurs = [
            'nivell' => $this->request->getPost('nivell'),
            'tipus' => $tipusFinal,
            'id_familia'     => $idFamilia,
            'matricula_viva' => 1
        ];

        $assignatures = $this->request->getPost('assignatures') ?? [];
        $optatives = $this->request->getPost('optatives') ?? [];

        $estudiModel->crearAmbAssignatures($dadesCurs, $assignatures, $optatives);

        $urlRetorn = $this->calcularUrlRetorn($tipusFinal);

        session()->setFlashdata('success', 'Curs creat correctament.');
        return redirect()->to('gestio/' . $urlRetorn);
    }

    public function editarCurs($id)
    {
        $model = new EstudiModel();
        $curs = $model->find($id);

        if (!$curs) {
            return redirect()->to('gestio/eso')->with('error', 'Curs no trobat.');
        }

        $assignaturaModel = new AssignaturaModel();
        $optativaModel = new OptativaModel();
        $assignatures = $assignaturaModel->where('id_estudi', $id)->findAll();
        $optatives = $optativaModel->where('id_estudi', $id)->findAll();

        $tipusAuto = '';
        if (str_contains($curs['tipus'], 'CFGM')) $tipusAuto = 'CFGM';
        elseif (str_contains($curs['tipus'], 'CFGS')) $tipusAuto = 'CFGS';
        elseif (str_contains($curs['tipus'], 'Batxillerat')) $tipusAuto = 'BATXILLERAT';

        $tipusNom = $curs['tipus'];
        if (!empty($tipusAuto)) {
            $prefixLabel = ($tipusAuto === 'BATXILLERAT') ? 'Batxillerat' : $tipusAuto;
            $tipusNom = str_replace($prefixLabel . ' - ', '', $curs['tipus']);
        }

        return view('gestio_cursos/crear', [
            'title' => 'Editar curs',
            'tipusAuto' => $tipusAuto,
            'tipusNom' => $tipusNom,
            'curs' => $curs,
            'assignatures' => $assignatures,
            'optatives' => $optatives,
            'url' => base_url('gestio/actualitzar-curs/' . $id)
        ]);
    }

    public function actualitzarCurs($id)
    {
        $model = new EstudiModel();
        
        $tipusEntrada = $this->request->getPost('tipus');
        $prefix = $this->request->getPost('tipus_prefix');
        $nomCicle = $this->request->getPost('tipus_nom');
        
        $tipusFinal = !empty($nomCicle) ? $prefix . $nomCicle : $tipusEntrada;

        $dadesCurs = [
            'id_estudi' => $id,
            'nivell' => $this->request->getPost('nivell'),
            'tipus' => $tipusFinal
        ];

        $model->save($dadesCurs);

        $assignaturaModel = new AssignaturaModel();
        $optativaModel = new OptativaModel();
        
        $assignaturaModel->where('id_estudi', $id)->delete();
        $assignaturesNoves = $this->request->getPost('assignatures') ?? [];
        foreach ($assignaturesNoves as $nom) {
            if (!empty(trim($nom))) {
                $assignaturaModel->insert(['nom' => $nom, 'id_estudi' => $id]);
            }
        }

        $optativaModel->where('id_estudi', $id)->delete();
        $optativesNoves = $this->request->getPost('optatives') ?? [];
        foreach ($optativesNoves as $nom) {
            if (!empty(trim($nom))) {
                $optativaModel->insert(['nom' => $nom, 'id_estudi' => $id]);
            }
        }

        $urlRetorn = $this->calcularUrlRetorn($tipusFinal);

        session()->setFlashdata('success', 'Curs actualitzat correctament.');
        return redirect()->to('gestio/' . $urlRetorn);
    }

    private function calcularUrlRetorn($tipusFinal)
    {
        $urlRetorn = 'eso';
        $tipusUpper = strtoupper($tipusFinal);

        if (str_contains($tipusUpper, 'BAT'))  $urlRetorn = 'batxillerat';
        elseif (str_contains($tipusUpper, 'CFGM')) $urlRetorn = 'fp-gm';
        elseif (str_contains($tipusUpper, 'CFGS')) $urlRetorn = 'fp-gs';
        elseif (str_contains($tipusUpper, 'FPB'))  $urlRetorn = 'fp-basica';
        elseif (str_contains($tipusUpper, 'PFI'))  $urlRetorn = 'pfi';
        
        return $urlRetorn;
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

                $assignaturaModel = new AssignaturaModel();
                $optativaModel = new OptativaModel();

                $curs['assignatures'] = $assignaturaModel
                    ->where('id_estudi', $curs['id_estudi'])
                    ->findAll();

                $curs['optatives'] = $optativaModel
                    ->where('id_estudi', $curs['id_estudi'])
                    ->findAll();

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
