<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AlumneModel;
use App\Libraries\CsvDataService;

class Auth extends BaseController
{
    protected $session;
    protected $alumneModel;
    protected CsvDataService $csvData;

    public function __construct()
    {
        $this->session     = session();
        $this->alumneModel = new AlumneModel();
        $this->csvData     = new CsvDataService();
        helper(['form', 'url']);
    }

    // ================================================================
    // REGISTRE
    // ================================================================

    public function signin()
    {
        return view('auth/singin', ['title' => 'Registrar-se']);
    }

    public function register()
    {
        $action = $this->request->getPost('action') ?? 'register';
        $dni    = strtoupper(trim($this->request->getPost('dni')));
        $email  = strtolower(trim($this->request->getPost('email')));

        if ($action === 'login') {
            $alumne = $this->alumneModel->where('dni', $dni)->where('email', $email)->first();
            if ($alumne) {
                $codi = $this->alumneModel->generarCodi();
                $this->alumneModel->update($alumne['id_alumne'], [
                    'codi'           => $codi,
                    'codi_expiracio' => date('Y-m-d H:i:s', strtotime('+24 hours')),
                    'estat'          => 'pendent'
                ]);
                return redirect()->to('/auth/login')
                    ->with('success', 'Codi regenerat! El teu codi és: ' . $codi . ' (comprova el teu correu)');
            }
            return redirect()->back()->withInput()
                ->with('error', 'No hi ha cap usuari registrat amb aquest DNI i correu. Registra\'t primer.');
        }

        // Validació contra el CSV
        $alumneCSV = $this->csvData->getAlumneByDniAndEmail($dni, $email);
        if (!$alumneCSV) {
            return redirect()->back()->withInput()
                ->with('error', 'El DNI que has introduït no es valid en aquest process de matriculació. 
                                 Esperi el seu torn per a poder matricular-se. 
                                 Si tens qualsevol dubte truqui a secretaria.
                                ');
        }

        // Crear registre a la BDD amb les dades del CSV
        $codi = $this->alumneModel->generarCodi();
        $this->alumneModel->insert([
            'dni'            => $dni,
            'email'          => $email,
            'nom'            => $alumneCSV['nom'],
            'cognom1'        => $alumneCSV['cognom1'],
            'cognom2'        => $alumneCSV['cognom2'] ?? null,
            'data_naixement' => $alumneCSV['data_naixement'],
            'telefon'        => $alumneCSV['telefon'] ?? null,
            'direccio'       => $alumneCSV['direccio'] ?? '',
            'codi'           => $codi,
            'codi_expiracio' => date('Y-m-d H:i:s', strtotime('+24 hours')),
            'estat'          => 'pendent'
        ]);

        return redirect()->to('/auth/login')
            ->with('success', 'Registre completat! El teu codi és: ' . $codi . ' (comprova el teu correu)');
    }

    // ================================================================
    // LOGIN
    // ================================================================

    public function login()
    {
        return view('auth/login', ['title' => 'Iniciar Sessió']);
    }

    public function doLogin()
    {
        $rules = [
            'dni'  => ['label' => 'DNI',  'rules' => 'required|exact_length[9]',
                       'errors' => ['required' => 'El DNI és obligatori', 'exact_length' => 'El DNI ha de tenir 9 caràcters']],
            'codi' => ['label' => 'Codi', 'rules' => 'required|exact_length[6]',
                       'errors' => ['required' => 'El codi és obligatori', 'exact_length' => 'El codi ha de tenir 6 dígits']],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dni    = strtoupper($this->request->getPost('dni'));
        $codi   = $this->request->getPost('codi');
        $alumne = $this->alumneModel->verificarCredencials($dni, $codi);

        if (!$alumne) {
            return redirect()->back()->withInput()
                ->with('error', 'DNI o codi incorrectes, o el codi ha expirat');
        }

        $this->alumneModel->update($alumne['id_alumne'], ['estat' => 'verificat']);
        $this->session->set([
            'alumne_id' => $alumne['id_alumne'],
            'dni'       => $alumne['dni'],
            'logged_in' => true
        ]);

        return redirect()->to('/forms/dadesPersonals');
    }

    // ================================================================
    // LOGOUT
    // ================================================================

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth/login')->with('success', 'Sessió tancada correctament');
    }
}