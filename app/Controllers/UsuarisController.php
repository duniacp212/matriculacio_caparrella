<?php

namespace App\Controllers;

use App\Models\UsuariModel;

class UsuarisController extends BaseController
{

    public function index()
    {
        $model = new UsuariModel();
        $data = [
            'title' => 'Gestió d\'Usuaris Administratius',
            'usuaris' => $model->findAll()
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

        $rules = [
            'nom' => 'required|min_length[2]|max_length[100]',
            'cognom1' => 'required|min_length[2]|max_length[100]',
            'cognom2' => 'permit_empty|max_length[100]',
            'dni_nie' => 'required|max_length[20]|is_unique[usuari.dni_nie]|dni_nie_valid',
            'email' => 'required|valid_email|is_unique[usuari.email]|max_length[150]',
            'telefon' => 'permit_empty|max_length[20]',
            'password' => 'required|min_length[6]',
            'rol' => 'required|in_list[super admin,administracio,secretaria]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $password = $this->request->getPost('password');
        $repetir = $this->request->getPost('repetir_password');

        if ($password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $usuari = new \App\Entities\Usuari();
        $usuari->nom = $this->request->getPost('nom');
        $usuari->cognom1 = $this->request->getPost('cognom1');
        $usuari->cognom2 = $this->request->getPost('cognom2');
        $usuari->dni_nie = $this->request->getPost('dni_nie');
        $usuari->email = $this->request->getPost('email');
        $usuari->telefon = $this->request->getPost('telefon');
        $usuari->usuari = $this->request->getPost('email');
        $usuari->rol = $this->request->getPost('rol');
        $usuari->password = $password;

        if ($model->save($usuari)) {
            $email = \Config\Services::email();
            $configEmail = getenv('email.SMTPUser') ?: 'noreply@caparrella.cat';

            $email->setFrom($configEmail, 'SECRETARIA INSTITUT CAPARRELLA');
            $email->setTo($usuari->email);
            $email->setSubject('Registre d\'usuari correcte - Institut Caparrella');

            $contingut = view('emails/registre_usuari', [
                'nom' => $usuari->nom,
                'usuari' => $usuari->usuari,
                'rol' => $usuari->rol
            ]);

            $email->setMessage($contingut);
            $email->send();

            return redirect()->to('/usuaris')->with('exit', 'Usuari creat correctament i notificació enviada.');
        }

        return redirect()->back()->withInput()->with('error', 'No s\'ha pogut crear l\'usuari.');
    }

    public function editar($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new UsuariModel();
        $usuari = $model->find($binaryId);

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

        $rules = [
            'nom' => 'required|min_length[2]|max_length[100]',
            'cognom1' => 'required|min_length[2]|max_length[100]',
            'cognom2' => 'permit_empty|max_length[100]',
            'dni_nie' => 'required|max_length[20]|is_unique[usuari.dni_nie,id_usuari,' . $binaryId . ']|dni_nie_valid',
            'email' => 'required|valid_email|is_unique[usuari.email,id_usuari,' . $binaryId . ']|max_length[150]',
            'telefon' => 'permit_empty|max_length[20]',
            'rol' => 'required|in_list[super admin,administracio,secretaria]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $password = $this->request->getPost('password');
        $repetir = $this->request->getPost('repetir_password');

        if (!empty($password) && $password !== $repetir) {
            return redirect()->back()->withInput()->with('error', 'Les contrasenyes no coincideixen.');
        }

        $usuari->nom = $this->request->getPost('nom');
        $usuari->cognom1 = $this->request->getPost('cognom1');
        $usuari->cognom2 = $this->request->getPost('cognom2');
        $usuari->dni_nie = $this->request->getPost('dni_nie');
        $usuari->email = $this->request->getPost('email');
        $usuari->telefon = $this->request->getPost('telefon');
        $usuari->usuari = $this->request->getPost('email');
        $usuari->rol = $this->request->getPost('rol');

        if (!empty($password)) {
            $usuari->password = $password;
        }

        if ($usuari->hasChanged()) {
            $model->save($usuari);
        }

        return redirect()->to('/usuaris')->with('exit', 'Usuari actualitzat correctament.');
    }

    public function eliminar($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $model = new UsuariModel();
        $usuari = $model->find($binaryId);

        if ($usuari) {
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
