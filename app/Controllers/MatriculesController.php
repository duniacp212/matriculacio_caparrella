<?php

namespace App\Controllers;

use App\Models\MatriculaModel;
use App\Models\AlumneModel;
use App\Models\AlumneTutorLegalModel;
use App\Models\DocumentAlumneModel;
use App\Models\BonificacioModel;
use App\Models\ServeiComplementariModel;

class MatriculesController extends BaseController
{
    public function matricula_alumne($id)
    {
        $model = new MatriculaModel();
        $alumneModel = new AlumneModel();
        $tutorModel = new AlumneTutorLegalModel();
        $documentModel = new DocumentAlumneModel();

        $matricula = $model->getMatriculaAmbDades($id);

        if (!$matricula) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Matrícula no trobada');
        }

        $alumne = $alumneModel->getExpedientPerId($matricula->id_alumne);
        $tutors = $tutorModel->getTutorsPerAlumne($matricula->id_alumne);

        $documents = $documentModel->getDocumentsPerAlumneIAny($matricula->id_alumne, $matricula->any_matricula);

        $bonificacioModel = new BonificacioModel();
        $bonificacions = $bonificacioModel->findAll();

        $serveiModel = new ServeiComplementariModel();
        $serveis = $serveiModel->findAll();
        $serveisContractats = $model->getServeisContractats($matricula->id_matricula);

        return view('matricules/matricula_alumne', [
            'title' => 'Dades de la matrícula',
            'matricula' => $matricula,
            'alumne' => $alumne,
            'tutors' => $tutors,
            'documents' => $documents,
            'bonificacions' => $bonificacions,
            'serveis' => $serveis,
            'serveisContractats' => $serveisContractats
        ]);
    }

    public function actualitzar($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new MatriculaModel();
        $alumneModel = new AlumneModel();
        $tutorModel = new AlumneTutorLegalModel();

        $matricula = $model->find($binaryId);
        if (!$matricula) {
            return redirect()->back()->with('error', 'Matrícula no trobada.');
        }

        $id_alumne = $matricula->id_alumne;

        $rules = [
            'nom'             => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'cognom1'         => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'cognom2'         => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'telefon'         => 'permit_empty|regex_match[/^(\+?[0-9]{9,15})$/]',
            'telefon2'        => 'permit_empty|regex_match[/^(\+?[0-9]{9,15})$/]',
            'tutor_nom.*'     => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'tutor_cognom1.*' => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'tutor_telefon.*' => 'permit_empty|regex_match[/^(\+?[0-9]{9,15})$/]',
        ];

        $missatges = [
            'nom'             => ['regex_match' => 'El nom de l\'alumne només pot contenir lletres, espais, guions o apòstrofs.'],
            'cognom1'         => ['regex_match' => 'El primer cognom de l\'alumne només pot contenir lletres, espais, guions o apòstrofs.'],
            'cognom2'         => ['regex_match' => 'El segon cognom de l\'alumne només pot contenir lletres, espais, guions o apòstrofs.'],
            'telefon'         => ['regex_match' => 'El format del telèfon de l\'alumne no és vàlid (mínim 9 números).'],
            'telefon2'        => ['regex_match' => 'El format del telèfon 2 de l\'alumne no és vàlid (mínim 9 números).'],
            'tutor_nom.*'     => ['regex_match' => 'El nom d\'un dels tutors només pot contenir lletres, espais, guions o apòstrofs.'],
            'tutor_cognom1.*' => ['regex_match' => 'El cognom d\'un dels tutors només pot contenir lletres, espais, guions o apòstrofs.'],
            'tutor_telefon.*' => ['regex_match' => 'El format del telèfon d\'un dels tutors no és vàlid (mínim 9 números).'],
        ];

        if (!$this->validate($rules, $missatges)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dadesAlumne = [
            'nom' => $this->request->getPost('nom'),
            'cognom1' => $this->request->getPost('cognom1'),
            'cognom2' => $this->request->getPost('cognom2'),
            'dni' => $this->request->getPost('dni'),
            'data_naixement' => $this->request->getPost('data_naixement'),
            'telefon' => $this->request->getPost('telefon'),
            'telefon2' => $this->request->getPost('telefon2'),
            'email' => $this->request->getPost('email'),
            'carrer' => $this->request->getPost('carrer'),
            'numero' => $this->request->getPost('numero'),
            'pis' => $this->request->getPost('pis'),
            'codi_postal' => $this->request->getPost('codi_postal'),
            'poblacio' => $this->request->getPost('poblacio'),
            'nacionalitat' => $this->request->getPost('nacionalitat'),
            'lloc_naixement' => $this->request->getPost('lloc_naixement'),
        ];

        $alumneModel->update($id_alumne, $dadesAlumne);

        $dadesMatricula = [
            'torn' => $this->request->getPost('torn'),
        ];

        $model->update($binaryId, $dadesMatricula);

        $idBonificacio = $this->request->getPost('id_bonificacio');
        $model->actualitzarBonificacio($binaryId, $idBonificacio);

        $serveisSels = $this->request->getPost('serveis') ?? [];
        $model->actualitzarServeisContractats($binaryId, $serveisSels);

        $tutorsIds = $this->request->getPost('tutor_id') ?? [];
        $tutorsNoms = $this->request->getPost('tutor_nom') ?? [];
        $tutorsCognoms = $this->request->getPost('tutor_cognom1') ?? [];
        $tutorsDnis = $this->request->getPost('tutor_dni') ?? [];
        $tutorsRols = $this->request->getPost('tutor_rol') ?? [];
        $tutorsTelefons = $this->request->getPost('tutor_telefon') ?? [];
        $tutorsEmails = $this->request->getPost('tutor_email') ?? [];

        foreach ($tutorsIds as $idx => $tutorId) {
            $tutorModel->update($tutorId, [
                'nom' => $tutorsNoms[$idx],
                'cognom1' => $tutorsCognoms[$idx],
                'dni' => $tutorsDnis[$idx],
                'rol' => $tutorsRols[$idx],
                'telefon' => $tutorsTelefons[$idx],
                'email' => $tutorsEmails[$idx],
            ]);
        }

        return redirect()->to(base_url('matricules/matricula_alumne/' . $id))->with('exit', 'Dades actualitzades correctament.');
    }

    public function validar_matricula($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new MatriculaModel();

        $model->update($binaryId, ['estat' => 'Validat']);

        return redirect()->back()->with('exit', 'Matrícula validada correctament.');
    }

    public function invalidar_matricula($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new MatriculaModel();

        $model->update($binaryId, ['estat' => 'Pendent']);

        return redirect()->back()->with('exit', 'Matrícula invalidada correctament.');
    }

    public function marcar_pagat($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new MatriculaModel();

        $model->update($binaryId, ['data_pagament' => date('Y-m-d')]);

        return redirect()->back()->with('exit', 'Pagament registrat correctament.');
    }

    public function marcar_pendent($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new MatriculaModel();

        $model->update($binaryId, ['data_pagament' => null]);

        return redirect()->back()->with('exit', 'Pagament marcat com a NO pagat.');
    }
}
