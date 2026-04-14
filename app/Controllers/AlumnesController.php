<?php

namespace App\Controllers;

use App\Models\AlumneModel;
use App\Models\MatriculaModel;
use App\Models\EstudiModel;

class AlumnesController extends BaseController
{


    public function index()
    {
        $request = service('request');

        $filtres = [
            'any' => $request->getGet('any'),
            'estudi' => $request->getGet('estudi'),
            'curs' => $request->getGet('curs'),
            'torn' => $request->getGet('torn'),
            'familia' => $request->getGet('familia'),
            'cicle' => $request->getGet('cicle'),
            'estat' => $request->getGet('estat'),
            'pagament' => $request->getGet('pagament'),
            'bonificats' => $request->getGet('bonificacio'),
            'cerca' => $request->getGet('cerca'),
        ];

        $model = new AlumneModel();
        $alumnes = $model->getAlumnesAmbMatricula($filtres);

        $estudiModel = new EstudiModel();
        $cicles = $estudiModel->obtenirCicles();
        $cursos = $estudiModel->obtenirCursos();
        $estudis = $estudiModel->obtenirEstudis();
        $families = $estudiModel->obtenirFamilies();

        return view('alumnes/index', [
            'title' => 'Alumnes / Expedients',
            'alumnes' => $alumnes,
            'filtres' => $filtres,
            'cicles' => $cicles,
            'cursos' => $cursos,
            'estudis' => $estudis,
            'families' => $families
        ]);
    }

    public function resumMatriculats()
    {
        $request = service('request');
        $anySeleccionat = $request->getGet('any');

        $model = new MatriculaModel();
        $files = $model->getResumMatriculats($anySeleccionat);

        $organitzat = [];
        $totalGeneral = 0;

        foreach ($files as $fila) {
            $organitzat[$fila['estudi']][] = $fila;
            $totalGeneral += $fila['total'];
        }

        return view('alumnes/resum_matriculats', [
            'title' => 'Resum d’alumnes matriculats',
            'dades' => $organitzat,
            'totalGeneral' => $totalGeneral,
            'anySeleccionat' => $anySeleccionat
        ]);
    }

    public function exportarResumPdf()
    {
        $request = service('request');
        $anySeleccionat = $request->getGet('any');

        $model = new MatriculaModel();
        $files = $model->getResumMatriculats($anySeleccionat);

        $organitzat = [];
        $totalGeneral = 0;

        foreach ($files as $fila) {
            $organitzat[$fila['estudi']][] = $fila;
            $totalGeneral += $fila['total'];
        }

        $html = view('alumnes/resum_pdf', [
            'dades' => $organitzat,
            'totalGeneral' => $totalGeneral,
            'anySeleccionat' => $anySeleccionat
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }

    public function cercaGlobal()
    {
        $request = service('request');
        $q = $request->getGet('q');

        $model = new AlumneModel();

        $resultats = [];

        if (!empty($q)) {
            $resultats = $model->cercaGlobal($q);
        }

        return view('alumnes/cerca', [
            'title' => 'Resultats de la cerca',
            'resultats' => $resultats,
            'q' => $q
        ]);
    }

    public function contacte(int $id)
    {
        $model = new AlumneModel();
        $alumne = $model->getContactePerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        return view('alumnes/contacte', [
            'title' => 'Contacte alumne',
            'alumne' => $alumne
        ]);
    }

    public function expedient(int $id)
    {
        $model = new AlumneModel();
        $alumne = $model->getExpedientPerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        return view('alumnes/expedient', [
            'title' => 'Expedient de l’alumne',
            'alumne' => $alumne
        ]);
    }

    public function enviar_correu(int $id)
    {
        $model = new AlumneModel();
        $alumne = $model->getContactePerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $request = service('request');
        $motiu   = $request->getPost('motiu');
        $missatge = $request->getPost('missatge');

        $dades = [
            'alumne'   => $alumne,
            'motiu'    => $motiu,
            'missatge' => $missatge,
        ];

        $email = \Config\Services::email();

        $emailUser = getenv('email.SMTPUser') ?: 'noreply@caparrella.cat';
        $email->setFrom($emailUser, 'SECRETARIA INSTITUT CAPARRELLA');
        $email->setTo($alumne['email']);
        $email->setSubject('Avís de Secretaria Institut Caparrella: ' . $motiu);

        $contingutHtml = view('emails/contacte', $dades);
        $email->setMessage($contingutHtml);

        if ($email->send()) {
            return redirect()->to(base_url('alumnes/contacte/' . $id))->with('exit', 'El correu s\'ha enviat correctament a l\'alumne.');
        } else {
            return redirect()->to(base_url('alumnes/contacte/' . $id))->with('error', 'Hi ha hagut un error enviant el correu. Revisa la configuració (.env).');
        }
    }
}
