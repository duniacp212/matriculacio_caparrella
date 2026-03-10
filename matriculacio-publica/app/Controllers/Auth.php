<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
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
    $rules = [
        'dni' => [
            'label' => 'DNI',
            'rules' => 'required|exact_length[9]',
            'errors' => [
                'required' => 'El DNI és obligatori',
                'exact_length' => 'El DNI ha de tenir 9 caràcters'
            ]
        ],
        'email' => [
            'label' => 'Correu electrònic',
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'El correu és obligatori',
                'valid_email' => 'El correu no és vàlid'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // Aquí podries guardar a la BD si vols

    return redirect()->to('/auth/login')
        ->with('success', 'Usuari registrat correctament');
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
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $dni = $this->request->getPost('dni');

    // Simulació d'inici de sessió temporal sense codi
    $this->session->set([
        'dni' => $dni,
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
