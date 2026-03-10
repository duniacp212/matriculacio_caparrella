<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Forms extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
        helper(['form', 'url']);
    }

    /**
     * Verificar autenticació
     */
    private function checkAuth()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Has d\'iniciar sessió primer');
        }
        return null;
    }

    /**
     * =========================
     * DADES PERSONALS
     * =========================
     */

    public function dadesPersonals()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        return view('formsviews/dadesPersonals', [
            'title' => 'Dades Personals'
        ]);
    }

    public function saveDadesPersonals()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $rules = [
            'nom' => 'required|min_length[2]',
            'cognoms' => 'required|min_length[2]',
            'data_naixement' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->session->set('dades_personals', $this->request->getPost());

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()
                ->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/formsviews/dadesTutors');
    }

    /**
     * =========================
     * DADES TUTORS
     * =========================
     */

    public function dadesTutors()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        return view('formsviews/dadesTutors', [
            'title' => 'Dades dels Tutors'
        ]);
    }

    public function saveDadesTutors()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $rules = [
            'nom_tutor1' => 'required|min_length[2]',
            'telefon_tutor1' => 'required|min_length[9]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->session->set('dades_tutors', $this->request->getPost());

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()
                ->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/formsviews/dadesCicle');
    }

    /**
     * =========================
     * DADES CICLE
     * =========================
     */

    public function dadesCicle()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        return view('formsviews/dadesCicle', [
            'title' => 'Selecció de Cicle'
        ]);
    }

    public function saveDadesCicle()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $rules = [
            'curs' => 'required|in_list[1,2]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Gestió arxiu
        $resguard_file = '';
        $file = $this->request->getFile('resguard_notes');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/resguards', $newName);
            $resguard_file = $newName;
        }

        $this->session->set('dades_cicle', [
            'curs' => $this->request->getPost('curs'),
            'acceptacio_matricula' => $this->request->getPost('acceptacio_matricula') ? 1 : 0,
            'matriculacio_moduls' => $this->request->getPost('matriculacio_moduls') ? 1 : 0,
            'resguard_notes' => $resguard_file
        ]);

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()
                ->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/formsviews/documentacio');
    }

    /**
     * =========================
     * DOCUMENTACIÓ
     * =========================
     */

    public function documentacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        return view('formsviews/documentacio', [
            'title' => 'Documentació Personal'
        ]);
    }

    public function saveDocumentacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $rules = [
            'dni' => 'required|min_length[9]|max_length[9]',
            'targeta_sanitaria' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $documents = [];
        $files = ['dni_cara_a', 'dni_cara_b', 'targeta_cara_a', 'targeta_cara_b'];

        foreach ($files as $fileName) {
            $file = $this->request->getFile($fileName);

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/documents', $newName);
                $documents[$fileName] = $newName;
            }
        }

        $this->session->set('documentacio', [
            'dni' => $this->request->getPost('dni'),
            'targeta_sanitaria' => $this->request->getPost('targeta_sanitaria'),
            'documents' => $documents
        ]);

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()
                ->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/formsviews/confirmacio')
            ->with('success', 'Inscripció completada amb èxit!');
    }

    /**
     * =========================
     * CONFIRMACIÓ
     * =========================
     */

    public function confirmacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        return view('formsviews/confirmacio', [
            'title' => 'Confirmació',
            'dades_personals' => $this->session->get('dades_personals'),
            'dades_tutors' => $this->session->get('dades_tutors'),
            'dades_cicle' => $this->session->get('dades_cicle'),
            'documentacio' => $this->session->get('documentacio')
        ]);
    }
}
