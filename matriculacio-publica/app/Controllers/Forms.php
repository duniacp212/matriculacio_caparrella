<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AlumneModel;
use App\Models\TutorModel;
use App\Models\InscripcioModel;

class Forms extends BaseController
{
    protected $session;
    protected $alumneModel;
    protected $tutorModel;
    protected $inscripcioModel;

    public function __construct()
    {
        $this->session = session();
        $this->alumneModel = new AlumneModel();
        $this->tutorModel = new TutorModel();
        $this->inscripcioModel = new InscripcioModel();
        helper(['form', 'url']);
    }

    private function checkAuth()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Has d\'iniciar sessió primer');
        }
        return null;
    }

    private function getCurrentAlumne()
    {
        $alumne_id = $this->session->get('alumne_id');
        if (!$alumne_id) return null;
        return $this->alumneModel->find($alumne_id);
    }

    public function dadesPersonals()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        return view('formsviews/dadesPersonals', ['title' => 'Dades Personals', 'alumne' => $alumne]);
    }

    public function saveDadesPersonals()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $rules = [
            'nom' => 'required|min_length[2]',
            'cognoms' => 'required|min_length[2]',
            'data_naixement' => 'required|valid_date',
            'telefon' => 'required|min_length[9]',
            'correu' => 'required|valid_email',
            'adreca' => 'required',
            'municipi' => 'required',
            'codi_postal' => 'required|exact_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $this->alumneModel->update($alumne['id'], [
            'nom' => $this->request->getPost('nom'),
            'cognoms' => $this->request->getPost('cognoms'),
            'data_naixement' => $this->request->getPost('data_naixement'),
            'poblacio_naixement' => $this->request->getPost('poblacio_naixement'),
            'telefon' => $this->request->getPost('telefon'),
            'correu' => $this->request->getPost('correu'),
            'adreca' => $this->request->getPost('adreca'),
            'municipi' => $this->request->getPost('municipi'),
            'codi_postal' => $this->request->getPost('codi_postal')
        ]);

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/forms/dadesTutors');
    }

    public function dadesTutors()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        $tutors = $this->tutorModel->getByAlumne($alumne['id']);
        return view('formsviews/dadesTutors', ['title' => 'Dades dels Tutors', 'tutors' => $tutors]);
    }

    public function saveDadesTutors()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $rules = [
            'nom_tutor1' => 'required|min_length[2]',
            'cognoms_tutor1' => 'required|min_length[2]',
            'telefon_tutor1' => 'required|min_length[9]',
            'correu_tutor1' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $data = [
            'alumne_id' => $alumne['id'],
            'nom_tutor1' => $this->request->getPost('nom_tutor1'),
            'cognoms_tutor1' => $this->request->getPost('cognoms_tutor1'),
            'telefon_tutor1' => $this->request->getPost('telefon_tutor1'),
            'correu_tutor1' => $this->request->getPost('correu_tutor1'),
            'nom_tutor2' => $this->request->getPost('nom_tutor2'),
            'cognoms_tutor2' => $this->request->getPost('cognoms_tutor2'),
            'telefon_tutor2' => $this->request->getPost('telefon_tutor2'),
            'correu_tutor2' => $this->request->getPost('correu_tutor2'),
            'circumstancies_especials' => $this->request->getPost('circumstancies_especials'),
            'situacions_singulars' => $this->request->getPost('situacions_singulars')
        ];

        $existing = $this->tutorModel->getByAlumne($alumne['id']);
        if ($existing) {
            $this->tutorModel->update($existing['id'], $data);
        } else {
            $this->tutorModel->insert($data);
        }

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/forms/dadesCicle');
    }

    public function dadesCicle()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id']);
        return view('formsviews/dadesCicle', ['title' => 'Dades del Cicle', 'inscripcio' => $inscripcio]);
    }

    public function saveDadesCicle()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $resguard_file = null;
        $file = $this->request->getFile('resguard_notes');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = WRITEPATH . 'uploads/resguards/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $file->move($uploadPath, $newName);
            $resguard_file = $newName;
        }

        $data = [
            'alumne_id' => $alumne['id'],
            'curs' => $this->request->getPost('curs'),
            'acceptacio_matricula' => $this->request->getPost('acceptacio_matricula') ? 1 : 0,
            'matriculacio_moduls' => $this->request->getPost('matriculacio_moduls') ? 1 : 0,
            'estat' => 'esborrany'
        ];

        if ($resguard_file) $data['resguard_notes'] = $resguard_file;

        $existing = $this->inscripcioModel->getByAlumne($alumne['id']);
        if ($existing) {
            $this->inscripcioModel->update($existing['id'], $data);
        } else {
            $this->inscripcioModel->insert($data);
        }

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/forms/documentacio');
    }

    public function downloadResguard($filename)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $filepath = WRITEPATH . 'uploads/resguards/' . $filename;
        if (!file_exists($filepath)) return redirect()->back()->with('error', 'Fitxer no trobat');
        return $this->response->download($filepath, null);
    }

    public function documentacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id']);
        return view('formsviews/documentacio', ['title' => 'Documentació', 'inscripcio' => $inscripcio]);
    }

    public function saveDocumentacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $uploadPath = WRITEPATH . 'uploads/documents/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $data = ['dni' => $this->request->getPost('dni')];
        $files = ['dni_cara_a', 'dni_cara_b', 'targeta_cara_a', 'targeta_cara_b'];
        
        foreach ($files as $fileKey) {
            $file = $this->request->getFile($fileKey);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);
                $data[$fileKey] = $newName;
            }
        }

        $data['targeta_sanitaria'] = $this->request->getPost('targeta_sanitaria');

        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id']);
        if ($inscripcio) {
            $this->inscripcioModel->update($inscripcio['id'], $data);
        } else {
            $data['alumne_id'] = $alumne['id'];
            $this->inscripcioModel->insert($data);
        }

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()->with('success', 'Documents guardats com a esborrany');
        }

        $this->inscripcioModel->update($inscripcio['id'], ['estat' => 'completat']);
        $this->alumneModel->update($alumne['id'], ['estat' => 'completat']);

        return redirect()->to('/forms/confirmacio')->with('success', 'Inscripció completada amb èxit!');
    }

    public function confirmacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        $tutors = $this->tutorModel->getByAlumne($alumne['id']);
        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id']);
        return view('formsviews/confirmacio', [
            'title' => 'Confirmació',
            'alumne' => $alumne,
            'tutors' => $tutors,
            'inscripcio' => $inscripcio
        ]);
    }
}
