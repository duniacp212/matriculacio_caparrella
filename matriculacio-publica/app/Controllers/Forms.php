<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AlumneModel;
use App\Models\TutorModel;
use App\Models\InscripcioModel;
use App\Libraries\CsvDataService;

class Forms extends BaseController
{
    protected $session;
    protected $alumneModel;
    protected $tutorModel;
    protected $inscripcioModel;
    protected CsvDataService $csvData;

    public function __construct()
    {
        $this->session         = session();
        $this->alumneModel     = new AlumneModel();
        $this->tutorModel      = new TutorModel();
        $this->inscripcioModel = new InscripcioModel();
        $this->csvData         = new CsvDataService();
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

    private function getCurrentAlumne(): ?array
    {
        $alumne_id = $this->session->get('alumne_id');
        if (!$alumne_id) return null;
        return $this->alumneModel->find($alumne_id);
    }

    // ================================================================
    // DADES PERSONALS
    // ================================================================

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
            'nom'         => 'required|min_length[2]',
            'cognoms'     => 'required|min_length[2]',
            'data_naixement' => 'required|valid_date',
            'telefon'     => 'required|min_length[9]',
            'correu'      => 'required|valid_email',
            'adreca'      => 'required',
            'municipi'    => 'required',
            'codi_postal' => 'required|exact_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $this->alumneModel->update($alumne['id_alumne'], [
            'nom'              => $this->request->getPost('nom'),
            'cognoms'          => $this->request->getPost('cognoms'),
            'data_naixement'   => $this->request->getPost('data_naixement'),
            'poblacio_naixement' => $this->request->getPost('poblacio_naixement'),
            'telefon'          => $this->request->getPost('telefon'),
            'correu'           => $this->request->getPost('correu'),
            'adreca'           => $this->request->getPost('adreca'),
            'municipi'         => $this->request->getPost('municipi'),
            'codi_postal'      => $this->request->getPost('codi_postal')
        ]);

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()->with('success', 'Dades guardades com a esborrany');
        }

        return redirect()->to('/forms/dadesTutors');
    }

    // ================================================================
    // DADES TUTORS
    // ================================================================

    public function dadesTutors()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        $tutors = $this->tutorModel->getByAlumne($alumne['id_alumne']);
        return view('formsviews/dadesTutors', ['title' => 'Dades dels Tutors', 'tutors' => $tutors]);
    }

    public function saveDadesTutors()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $rules = [
            'nom_tutor1'     => 'required|min_length[2]',
            'cognoms_tutor1' => 'required|min_length[2]',
            'telefon_tutor1' => 'required|min_length[9]',
            'correu_tutor1'  => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $data = [
            'id_alumne'               => $alumne['id_alumne'],
            'nom_tutor1'              => $this->request->getPost('nom_tutor1'),
            'cognoms_tutor1'          => $this->request->getPost('cognoms_tutor1'),
            'telefon_tutor1'          => $this->request->getPost('telefon_tutor1'),
            'correu_tutor1'           => $this->request->getPost('correu_tutor1'),
            'nom_tutor2'              => $this->request->getPost('nom_tutor2'),
            'cognoms_tutor2'          => $this->request->getPost('cognoms_tutor2'),
            'telefon_tutor2'          => $this->request->getPost('telefon_tutor2'),
            'correu_tutor2'           => $this->request->getPost('correu_tutor2'),
            'circumstancies_especials' => $this->request->getPost('circumstancies_especials'),
            'situacions_singulars'    => $this->request->getPost('situacions_singulars')
        ];

        $existing = $this->tutorModel->getByAlumne($alumne['id_alumne']);
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

    // ================================================================
    // DADES CICLE — ara llegeix estudi i assignatures del CSV
    // ================================================================

    public function dadesCicle()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $alumne    = $this->getCurrentAlumne();
        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id_alumne']);

        // Dades del CSV per a aquest alumne
        $alumneCSV   = $this->csvData->getAlumneByDni($alumne['dni']);
        $assignatures = [];
        $estuiTipus  = '';
        $estudiNivell = '';

        if ($alumneCSV) {
            $estuiTipus   = $alumneCSV['estudi_tipus'];
            $estudiNivell = $alumneCSV['estudi_nivell'];
            $assignatures = $alumneCSV['assignatures'];
        }

        return view('formsviews/dadesCicle', [
            'title'        => 'Dades del Cicle',
            'inscripcio'   => $inscripcio,
            'estudi_tipus' => $estuiTipus,
            'estudi_nivell' => $estudiNivell,
            'assignatures' => $assignatures,
        ]);
    }

    public function saveDadesCicle()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $resguard_file = null;
        $file = $this->request->getFile('resguard_notes');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName    = $file->getRandomName();
            $uploadPath = WRITEPATH . 'uploads/resguards/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $file->move($uploadPath, $newName);
            $resguard_file = $newName;
        }

        // Obtenim l'estudi del CSV per guardar id_estudi correctament
        $alumneCSV  = $this->csvData->getAlumneByDni($alumne['dni']);
        $estudiTipus = $alumneCSV['estudi_tipus']  ?? '';
        $estudiNivell = $alumneCSV['estudi_nivell'] ?? '';

        // Cerquem l'id_estudi a la BDD fent coincidir tipus+nivell
        $db          = \Config\Database::connect();
        $estudiBDD   = $db->table('estudi')
                          ->where('tipus', $estudiTipus)
                          ->where('nivell', $estudiNivell)
                          ->get()->getRowArray();
        $id_estudi   = $estudiBDD['id_estudi'] ?? 1; // fallback 1 si no existeix

        $data = [
            'id_alumne'            => $alumne['id_alumne'],
            'id_estudi'            => $id_estudi,
            'data'                 => date('Y-m-d'),
            'estat'                => 'esborrany',
            'torn'                 => 1,
            'observacions'         => $this->request->getPost('acceptacio_matricula') ? 'Accepta mòduls suspesos' : null,
        ];

        // resguard_notes no és un camp de la taula matricula, es guarda a part si cal
        // if ($resguard_file) $data['resguard_notes'] = $resguard_file;

        $existing = $this->inscripcioModel->getByAlumne($alumne['id_alumne']);
        if ($existing) {
            $this->inscripcioModel->update($existing['id_matricula'], $data);
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

    // ================================================================
    // DOCUMENTACIÓ
    // ================================================================

    public function documentacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne    = $this->getCurrentAlumne();
        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id_alumne']);
        return view('formsviews/documentacio', ['title' => 'Documentació', 'inscripcio' => $inscripcio]);
    }

    public function saveDocumentacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $uploadPath = WRITEPATH . 'uploads/documents/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $data  = ['dni' => $this->request->getPost('dni')];
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

        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id_alumne']);
        if ($inscripcio) {
            $this->inscripcioModel->update($inscripcio['id'], $data);
        } else {
            $data['id_alumne'] = $alumne['id_alumne'];
            $this->inscripcioModel->insert($data);
        }

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()->with('success', 'Documents guardats com a esborrany');
        }

        $this->inscripcioModel->update($inscripcio['id_matricula'], ['estat' => 'completat']);
        $this->alumneModel->update($alumne['id_alumne'], ['estat' => 'completat']);

        return redirect()->to('/forms/confirmacio')->with('success', 'Inscripció completada amb èxit!');
    }

    // ================================================================
    // CONFIRMACIÓ
    // ================================================================

    public function confirmacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne    = $this->getCurrentAlumne();
        $tutors    = $this->tutorModel->getByAlumne($alumne['id_alumne']);
        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id_alumne']);

        // Afegim les assignatures del CSV a la vista de confirmació
        $alumneCSV   = $this->csvData->getAlumneByDni($alumne['dni']);
        $assignatures = $alumneCSV['assignatures'] ?? [];

        return view('formsviews/confirmacio', [
            'title'        => 'Confirmació',
            'alumne'       => $alumne,
            'tutors'       => $tutors,
            'inscripcio'   => $inscripcio,
            'assignatures' => $assignatures,
        ]);
    }
}
