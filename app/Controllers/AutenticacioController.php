<?php

namespace App\Controllers;

use App\Models\UsuariModel;
use OTPHP\TOTP;

class AutenticacioController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function autenticacio()
    {
        $session = session();

        $nomUsuari = $this->request->getPost('username');
        $contrasenya = $this->request->getPost('password');

        $model = new UsuariModel();

        $usuari = $model->groupStart()
                        ->where('usuari', $nomUsuari)
                        ->orWhere('email', $nomUsuari)
                        ->groupEnd()
                        ->first();

        if ($usuari && password_verify($contrasenya, $usuari->password)) {
            $session->set('id_usuari_pendent_2fa', $usuari->id_usuari);
            
            if ($usuari->te_2fa) {
                return redirect()->to(base_url('2fa/verificar'));
            }

            return redirect()->to(base_url('2fa/configurar'));
        }

        return redirect()->back()->with('error', 'Usuari o contrasenya incorrectes');
    }

    public function configurar2fa()
    {
        $idUsuariStr = session()->get('logged_in') ? session()->get('id_usuari') : session()->get('id_usuari_pendent_2fa');

        if (!$idUsuariStr) {
            return redirect()->to(base_url('login'));
        }

        $idUsuari = $this->getBinaryId($idUsuariStr);
        $model = new UsuariModel();
        $usuari = $model->find($idUsuari);

        if ($usuari->te_2fa) {
            return redirect()->to('/perfil')->with('error', 'El 2FA ja està activat.');
        }

        $secretTemporal = session()->get('secret_2fa_temporal');
        
        if ($secretTemporal) {
            $otp = TOTP::create($secretTemporal);
        } else {
            $otp = TOTP::create();
            session()->set('secret_2fa_temporal', $otp->getSecret());
        }

        $otp->setLabel($usuari->email);
        $otp->setIssuer('Matriculació INS Caparrella');

        return view('auth/2fa_setup', [
            'secret'     => $otp->getSecret(),
            'qrCodeUri'  => $otp->getProvisioningUri()
        ]);
    }

    public function activar2fa()
    {
        $idUsuariStr = session()->get('logged_in') ? session()->get('id_usuari') : session()->get('id_usuari_pendent_2fa');

        if (!$idUsuariStr) {
            return redirect()->to(base_url('login'));
        }

        $codi = trim($this->request->getPost('codi'));
        $secret = session()->get('secret_2fa_temporal');

        if (!$secret) {
            return redirect()->to(base_url('2fa/configurar'))->with('error', 'La sessió ha caducat.');
        }

        $otp = TOTP::create($secret);

        if ($otp->verify($codi, null, 2)) {
            $idUsuari = $this->getBinaryId($idUsuariStr);
            $model = new UsuariModel();
            $usuari = $model->find($idUsuari);
            
            $usuari->secret_2fa = $secret;
            $usuari->te_2fa     = 1;
            
            $model->save($usuari);

            session()->remove('secret_2fa_temporal');

            if (!session()->get('logged_in')) {
                $usuari = $model->find($idUsuari);
                $this->setUserSession($usuari);
                return redirect()->to(base_url('alumnes'));
            }

            return redirect()->to(base_url('perfil'))->with('exit', '2FA activat correctament!');
        }

        return redirect()->back()->with('error', 'Codi incorrecte.');
    }

    public function verificar2fa()
    {
        if (!session()->has('id_usuari_pendent_2fa')) {
            return redirect()->to(base_url('login'));
        }

        return view('auth/2fa_verificar');
    }

    public function validar2fa()
    {
        $idUsuariStr = session()->get('id_usuari_pendent_2fa');
        $codi = trim($this->request->getPost('codi'));

        if (!$idUsuariStr) {
            return redirect()->to(base_url('login'));
        }

        $idUsuari = $this->getBinaryId($idUsuariStr);
        $model = new UsuariModel();
        $usuari = $model->find($idUsuari);

        $otp = TOTP::create($usuari->secret_2fa);

        if ($otp->verify($codi, null, 2)) {
            $this->setUserSession($usuari);
            return redirect()->to(base_url('alumnes'));
        }

        return redirect()->back()->with('error', 'Codi invàlid');
    }

    private function getBinaryId($id)
    {
        if (empty($id)) return null;
        return (strlen($id) === 16) ? $id : hex2bin(str_replace('-', '', $id));
    }

    private function setUserSession($usuari)
    {
        $nomComplet = $usuari->nom . ' ' . $usuari->cognom1 . ($usuari->cognom2 ? ' ' . $usuari->cognom2 : '');
        
        session()->set([
            'logged_in'   => true,
            'id_usuari'   => $usuari->id_usuari,
            'nom_complet' => $nomComplet,
            'rol'         => $usuari->rol
        ]);

        session()->remove('id_usuari_pendent_2fa');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}