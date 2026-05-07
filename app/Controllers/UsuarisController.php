<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class UsuarisController extends BaseController
{

    public function index()
    {
        $model = new UsuariModel();
        $rolSessio = session()->get('rol');

        if ($rolSessio === 'super admin') {
            $usuaris = $model->findAll();
        } else {
            $usuaris = $model->where('rol !=', 'super admin')->findAll();
        }

        $data = [
            'title' => 'Gestió d\'Usuaris Administratius',
            'usuaris' => $usuaris
        ];
        return view('usuaris/index', $data);
    }

    public function nou()
    {
        $data = [
            'title' => 'Nou Usuari',
            'usuari' => new \App\Entities\Usuari(),
            'url' => base_url('usuaris/guardar')
        ];
        return view('usuaris/form', $data);
    }

    public function guardar()
    {
        $model = new UsuariModel();

        $rolPost = $this->request->getPost('rol');
        if (session()->get('rol') !== 'super admin' && $rolPost === 'super admin') {
            return redirect()->back()->withInput()->with('error', 'No tens permisos per assignar el rol de super admin.');
        }

        $password = $this->request->getPost('password');
        $repetir = $this->request->getPost('repetir_password');

        if ($password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $dadesCreacio = [
            'nom' => $this->request->getPost('nom'),
            'cognom1' => $this->request->getPost('cognom1'),
            'cognom2' => $this->request->getPost('cognom2'),
            'dni_nie' => $this->request->getPost('dni_nie'),
            'email' => $this->request->getPost('email'),
            'telefon' => $this->request->getPost('telefon'),
            'usuari' => $this->request->getPost('email'),
            'rol' => $this->request->getPost('rol'),
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        if (!$model->insert($dadesCreacio)) {
            return redirect()->back()->withInput()->with('errors', $model->errors() ?: ['No s\'ha pogut crear l\'usuari.']);
        }

        $email = \Config\Services::email();
        $configEmail = getenv('email.SMTPUser') ?: 'noreply@caparrella.cat';

        $email->setFrom($configEmail, 'SECRETARIA INSTITUT CAPARRELLA');
        $email->setTo($dadesCreacio['email']);
        $email->setSubject('Registre d\'usuari correcte - Institut Caparrella');

        $contingut = view('emails/registre_usuari', [
            'nom' => $dadesCreacio['nom'],
            'usuari' => $dadesCreacio['usuari'],
            'rol' => $dadesCreacio['rol']
        ]);

        $email->setMessage($contingut);
        $email->send();

        return redirect()->to('/usuaris')->with('exit', 'Usuari creat correctament i notificació enviada.');
    }

    public function editar($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new UsuariModel();
        $usuari = $model->find($binaryId);

        if (!$usuari) {
            return redirect()->to('/usuaris')->with('error', 'Usuari no trobat.');
        }

        if (session()->get('rol') !== 'super admin' && $usuari->rol === 'super admin') {
            return redirect()->to('/usuaris')->with('error', 'No tens permisos per gestionar aquest usuari.');
        }

        $data = [
            'title' => 'Editar Usuari',
            'usuari' => $usuari,
            'url' => base_url('usuaris/actualitzar/' . $id)
        ];
        return view('usuaris/form', $data);
    }

    public function actualitzar($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new UsuariModel();
        $usuari = $model->find($binaryId);

        if (session()->get('rol') !== 'super admin' && $usuari->rol === 'super admin') {
            return redirect()->to('/usuaris')->with('error', 'No tens permisos per gestionar aquest usuari.');
        }

        $rolPost = $this->request->getPost('rol');
        if (session()->get('rol') !== 'super admin' && $rolPost === 'super admin') {
            return redirect()->back()->withInput()->with('error', 'No tens permisos per assignar el rol de super admin.');
        }

        $password = $this->request->getPost('password');
        $repetir = $this->request->getPost('repetir_password');

        if (!empty($password) && $password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $dadesActualitzacio = [
            'nom' => $this->request->getPost('nom'),
            'cognom1' => $this->request->getPost('cognom1'),
            'cognom2' => $this->request->getPost('cognom2'),
            'dni_nie' => $this->request->getPost('dni_nie'),
            'email' => $this->request->getPost('email'),
            'telefon' => $this->request->getPost('telefon'),
            'usuari' => $this->request->getPost('email'),
            'rol' => $this->request->getPost('rol')
        ];

        if (!empty($password)) {
            $dadesActualitzacio['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!$model->actualitzarUsuari($binaryId, $dadesActualitzacio)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/usuaris')->with('exit', 'Usuari actualitzat correctament.');
    }

    public function eliminar($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new UsuariModel();
        $usuari = $model->find($binaryId);

        if ($usuari) {
            if (session()->get('rol') !== 'super admin' && $usuari->rol === 'super admin') {
                return redirect()->to('/usuaris')->with('error', 'No tens permisos per gestionar aquest usuari.');
            }
            $email = \Config\Services::email();
            $configEmail = getenv('email.SMTPUser') ?: 'noreply@caparrella.cat';

            $email->setFrom($configEmail, 'SECRETARIA INSTITUT CAPARRELLA');
            $email->setTo($usuari->email);
            $email->setSubject('Avís d\'eliminació de compte - Institut Caparrella');

            $contingut = view('emails/eliminacio_usuari', [
                'nom' => $usuari->nom,
                'usuari' => $usuari->usuari
            ]);

            $email->setMessage($contingut);
            $email->send();

            $model->delete($binaryId);
        }

        return redirect()->to('/usuaris')->with('exit', 'Usuari eliminat i notificació enviada.');
    }
}
