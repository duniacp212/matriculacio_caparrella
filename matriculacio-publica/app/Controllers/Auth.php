<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AlumneModel;

class Auth extends BaseController
{
    protected $session;
    protected $alumneModel;

    public function __construct()
    {
        $this->session = session();
        $this->alumneModel = new AlumneModel();
        helper(['form', 'url']);
    }

    /**
     * =========================
     * REGISTRE
     * =========================
     */

    public function signin()
    {
        return view('auth/singin', [
            'title' => 'Registrar-se'
        ]);
    }

    public function register()
    {
        $action = $this->request->getPost('action') ?? 'register';

        if ($action === 'login') {
            // Check if user exists
            $dni = strtoupper($this->request->getPost('dni'));
            $email = $this->request->getPost('email');

            $alumne = $this->alumneModel->where('dni', $dni)->where('email', $email)->first();

            if ($alumne) {
                // Generate new code
                $codi = $this->alumneModel->generarCodi();
                $this->alumneModel->update($alumne['id_alumne'], [
                    'codi' => $codi,
                    'codi_expiracio' => date('Y-m-d H:i:s', strtotime('+24 hours')),
                    'estat' => 'pendent'
                ]);

                return redirect()->to('/auth/login')
                    ->with('success', 'Codi regenerat! El teu codi és: ' . $codi . ' (comprova el teu correu)');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No hi ha cap usuari registrat amb aquest DNI i correu. Registra\'t primer.');
            }
        }

        // Register logic
        $rules = [
            'dni' => [
                'label' => 'DNI',
                'rules' => 'required|exact_length[9]|is_unique[alumne.dni]',
                'errors' => [
                    'required' => 'El DNI és obligatori',
                    'exact_length' => 'El DNI ha de tenir 9 caràcters',
                    'is_unique' => 'Aquest DNI ja està registrat'
                ]
            ],
            'email' => [
                'label' => 'Correu electrònic',
                'rules' => 'required|valid_email|is_unique[alumne.email]',
                'errors' => [
                    'required' => 'El correu és obligatori',
                    'valid_email' => 'El correu no és vàlid',
                    'is_unique' => 'Aquest correu ja està registrat'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Generar codi de 6 dígits
        $codi = $this->alumneModel->generarCodi();
        
        // Guardar a la base de dades
        $this->alumneModel->insert([
            'dni' => strtoupper($this->request->getPost('dni')),
            'email' => $this->request->getPost('email'),
            'codi' => $codi,
            'codi_expiracio' => date('Y-m-d H:i:s', strtotime('+24 hours')),
            'estat' => 'pendent'
        ]);

        // TODO: Enviar email amb el codi
        // Per ara, mostrem el codi a la pàgina
        
        return redirect()->to('/auth/login')
            ->with('success', 'Registre completat! El teu codi és: ' . $codi . ' (comprova el teu correu)');
    }

    /**
     * =========================
     * LOGIN
     * =========================
     */

    public function login()
    {
        return view('auth/login', [
            'title' => 'Iniciar Sessió'
        ]);
    }

  public function doLogin()
    {
        $rules = [
            'dni' => [
                'label' => 'DNI',
                'rules' => 'required|exact_length[9]',
                'errors' => [
                    'required' => 'El DNI és obligatori',
                    'exact_length' => 'El DNI ha de tenir 9 caràcters'
                ]
            ],
            'codi' => [
                'label' => 'Codi',
                'rules' => 'required|exact_length[6]',
                'errors' => [
                    'required' => 'El codi és obligatori',
                    'exact_length' => 'El codi ha de tenir 6 dígits'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $dni = strtoupper($this->request->getPost('dni'));
        $codi = $this->request->getPost('codi');

        // Verificar credencials a la base de dades
        $alumne = $this->alumneModel->verificarCredencials($dni, $codi);

        if (!$alumne) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'DNI o codi incorrectes, o el codi ha expirat');
        }

        // Actualitzar estat a verificat
        $this->alumneModel->update($alumne['id_alumne'], ['estat' => 'verificat']);

        // Guardar a sessió
        $this->session->set([
            'alumne_id' => $alumne['id_alumne'],
            'dni' => $alumne['dni'],
            'logged_in' => true
        ]);

        return redirect()->to('/forms/dadesPersonals');
    }

    /**
     * =========================
     * LOGOUT
     * =========================
     */

    public function logout()
    {
        $this->session->destroy();

        return redirect()->to('/auth/login')
            ->with('success', 'Sessió tancada correctament');
    }
}
