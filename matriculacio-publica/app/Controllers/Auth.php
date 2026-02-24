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
            'dni' => 'required|min_length[9]|max_length[9]',
            'codi' => 'required|min_length[4]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // TODO: Guardar usuari a base de dades

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
                'rules' => 'required',
                'errors' => [
                    'required' => 'El DNI és obligatori'
                ]
            ],
            'codi' => [
                'label' => 'Codi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El codi és obligatori'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $dni = $this->request->getPost('dni');
        $codi = $this->request->getPost('codi');

        // TODO: Validar realment contra BD
        // Exemple temporal:
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
