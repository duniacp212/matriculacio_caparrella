<?php

namespace App\Controllers;

use App\Models\AlumneModel;
use App\Models\MatriculaModel;
use App\Models\EstudiModel;
use App\Models\DocumentAlumneModel;
use App\Models\AlumneTutorLegalModel;

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

        $perPagina = 15;
        $paginador = service('pager');
        $paginador->setPath('/alumnes');

        $model = new AlumneModel();
        $total = $model->countAlumnesAmbMatricula($filtres);
        $pagina = (int) ($request->getGet('page') ?? 1);
        $offset = ($pagina - 1) * $perPagina;

        $alumnes = $model->getAlumnesAmbMatricula($filtres, $perPagina, $offset);

        $paginador->makeLinks($pagina, $perPagina, $total, 'bootstrap_full');

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
            'families' => $families,
            'paginador' => $paginador,
            'total' => $total,
        ]);
    }

    public function expedient($id)
    {
        $alumneModel = new AlumneModel();
        $documentModel = new DocumentAlumneModel();
        $tutorModel = new AlumneTutorLegalModel();

        $alumne = $alumneModel->getExpedientPerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $tutors = $tutorModel->getTutorsPerAlumne($id);
        $documents = $documentModel->getDocumentsPerAlumne($id);
        $matricules = $alumneModel->getHistorialMatricules($id);

        $matriculaModel = new MatriculaModel();
        foreach ($matricules as &$mat) {
            $mat['serveis'] = $matriculaModel->getServeisContractats($mat['id_matricula']);
        }

        return view('alumnes/expedient', [
            'title' => 'Expedient de l\'alumne',
            'alumne' => $alumne,
            'tutors' => $tutors,
            'documents' => $documents,
            'matricules' => $matricules,
        ]);
    }

    public function pujarDocument($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $alumneModel = new AlumneModel();
        $alumne = $alumneModel->find($binaryId);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $fitxer = $this->request->getFile('document');

        if (!$fitxer || !$fitxer->isValid()) {
            $error = $fitxer ? $fitxer->getErrorString() . ' (' . $fitxer->getError() . ')' : 'No s\'ha rebut cap fitxer.';
            return redirect()->back()->with('error', 'Error en la pujada: ' . $error);
        }

        if ($fitxer->hasMoved()) {
            return redirect()->back()->with('error', 'El fitxer ja s\'ha processat.');
        }

        $extensionsPermeses = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
        if (!in_array(strtolower($fitxer->getClientExtension()), $extensionsPermeses)) {
            return redirect()->back()->with('error', 'Tipus de fitxer no permès. Només PDF, imatges i documents Word.');
        }

        $any = date('Y');
        $mes = date('m');
        $dni = trim($alumne->dni);
        $carpeta = WRITEPATH . 'uploads/' . $any . '/' . $mes . '/' . $dni;

        if (!is_dir($carpeta)) {
            if (!mkdir($carpeta, 0755, true)) {
                return redirect()->back()->with('error', 'No s\'ha pogut crear la carpeta de destí. Revisa els permisos de WRITEPATH.');
            }
        }

        $nomOriginal = $fitxer->getClientName();
        $nomFitxer = $fitxer->getRandomName();

        if (!$fitxer->move($carpeta, $nomFitxer)) {
            return redirect()->back()->with('error', 'No s\'ha pogut moure el fitxer a la carpeta de destí.');
        }

        $documentModel = new DocumentAlumneModel();
        $nouDoc = new \App\Entities\DocumentAlumne();
        $nouDoc->id_alumne = $id;
        $nouDoc->nom_original = $nomOriginal;
        $nouDoc->nom_fitxer = $nomFitxer;
        $nouDoc->ruta = $any . '/' . $mes . '/' . $dni . '/' . $nomFitxer;
        $nouDoc->tipus = $this->request->getPost('tipus');
        $nouDoc->any_academic = $any;

        if (!$documentModel->save($nouDoc)) {
            return redirect()->back()->with('error', 'Error al guardar les dades del document a la base de dades.');
        }

        return redirect()->to(base_url('alumnes/expedient/' . $id))->with('exit', 'Document pujat correctament.');
    }

    public function actualitzarObservacions($idMatricula)
    {
        $binaryId = hex2bin(str_replace('-', '', $idMatricula));
        $matriculaModel = new MatriculaModel();

        $matricula = $matriculaModel->find($binaryId);
        if (!$matricula) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Matrícula no trobada');
        }

        $nouText = trim((string) $this->request->getPost('observacions'));

        if (!empty($nouText)) {
            $historial = json_decode($matricula->observacions ?? '', true);
            if (!is_array($historial)) {
                $historial = empty(trim((string) ($matricula->observacions ?? ''))) ? [] : [
                    ['id' => uniqid(), 'data' => date('Y-m-d H:i:s'), 'text' => $matricula->observacions]
                ];
            }

            $historial[] = [
                'id' => uniqid(),
                'data' => date('Y-m-d H:i:s'),
                'text' => $nouText
            ];

            $matricula->observacions = json_encode($historial);
            $matriculaModel->save($matricula);
        }

        return redirect()->back()->with('exit', 'Observació de matrícula afegida correctament.');
    }

    public function actualitzarObservacionsAlumne($idAlumne)
    {
        $binaryId = hex2bin(str_replace('-', '', $idAlumne));
        $alumneModel = new AlumneModel();

        $alumne = $alumneModel->find($binaryId);
        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $nouText = trim((string) $this->request->getPost('observacions'));

        if (!empty($nouText)) {
            $historial = json_decode($alumne->observacions ?? '', true);
            if (!is_array($historial)) {
                $historial = empty(trim((string) ($alumne->observacions ?? ''))) ? [] : [
                    ['id' => uniqid(), 'data' => date('Y-m-d H:i:s'), 'text' => $alumne->observacions]
                ];
            }

            $historial[] = [
                'id' => uniqid(),
                'data' => date('Y-m-d H:i:s'),
                'text' => $nouText
            ];

            $alumne->observacions = json_encode($historial);
            $alumneModel->save($alumne);
        }

        return redirect()->back()->with('exit', 'Observació de l\'alumne afegida correctament.');
    }

    public function eliminarObservacioAlumne($idAlumne, $idObservacio)
    {
        $binaryId = hex2bin(str_replace('-', '', $idAlumne));
        $alumneModel = new AlumneModel();

        $alumne = $alumneModel->find($binaryId);
        if ($alumne) {
            $historial = json_decode($alumne->observacions ?? '', true);
            if (is_array($historial)) {
                foreach ($historial as $index => $obs) {
                    if (isset($obs['id']) && $obs['id'] === $idObservacio) {
                        unset($historial[$index]);
                        break;
                    }
                }
                $alumne->observacions = json_encode(array_values($historial));
                $alumneModel->save($alumne);
            }
        }
        return redirect()->back()->with('exit', 'Observació eliminada correctament.');
    }

    public function eliminarObservacio($idMatricula, $idObservacio)
    {
        $binaryId = hex2bin(str_replace('-', '', $idMatricula));
        $matriculaModel = new MatriculaModel();

        $matricula = $matriculaModel->find($binaryId);
        if ($matricula) {
            $historial = json_decode($matricula->observacions, true);
            if (is_array($historial)) {
                foreach ($historial as $index => $obs) {
                    if (isset($obs['id']) && $obs['id'] === $idObservacio) {
                        unset($historial[$index]);
                        break;
                    }
                }
                $matricula->observacions = json_encode(array_values($historial));
                $matriculaModel->save($matricula);
            }
        }
        return redirect()->back()->with('exit', 'Observació eliminada correctament.');
    }

    public function eliminarDocument($idDocument)
    {
        $documentModel = new DocumentAlumneModel();
        $document = $documentModel->find($idDocument);

        if (!$document) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Document no trobat');
        }

        $idAlumne = $document->id_alumne;
        $ruta = WRITEPATH . 'uploads/' . $document->ruta;

        if (file_exists($ruta)) {
            unlink($ruta);
        }

        $documentModel->delete($idDocument);

        return redirect()->to(base_url('alumnes/expedient/' . $idAlumne))->with('exit', 'Document eliminat correctament.');
    }

    public function veureDocument(int $id)
    {
        $model = new DocumentAlumneModel();
        $document = $model->find($id);

        if (!$document) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Document no trobat');
        }

        $ruta = WRITEPATH . 'uploads/' . $document->ruta;

        if (!file_exists($ruta)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Fitxer no trobat');
        }

        $mime = mime_content_type($ruta);

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setBody(file_get_contents($ruta));
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
            'title' => 'Resum d\'alumnes matriculats',
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

    public function pdfExpedient($id)
    {
        $alumneModel = new AlumneModel();
        $alumne = $alumneModel->getExpedientPerId($id);
        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $tutorModel = new AlumneTutorLegalModel();
        $tutors = $tutorModel->getTutorsPerAlumne($id);
        $matricules = $alumneModel->getHistorialMatricules($id);

        $matriculaModel = new MatriculaModel();
        foreach ($matricules as &$mat) {
            $mat['serveis'] = $matriculaModel->getServeisContractats($mat['id_matricula']);
        }

        $html = view('alumnes/pdf_expedient', [
            'tipus' => 'Expedient complet',
            'alumne' => $alumne,
            'tutors' => $tutors,
            'matricules' => $matricules
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="expedient_' . $alumne->dni . '.pdf"')
            ->setBody($dompdf->output());
    }

    public function pdfMatricula($idMatricula)
    {
        $matriculaModel = new MatriculaModel();
        $matricula = $matriculaModel->getMatriculaAmbDades($idMatricula);

        if (!$matricula) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Matrícula no trobada');
        }

        $alumneModel = new AlumneModel();
        $alumne = $alumneModel->find(hex2bin(str_replace('-', '', $matricula->id_alumne)));

        $tutorModel = new AlumneTutorLegalModel();
        $tutors = $tutorModel->getTutorsPerAlumne($matricula->id_alumne);
        $serveis = $matriculaModel->getServeisContractats($idMatricula);

        $html = view('alumnes/pdf_matricula', [
            'tipus' => 'Resguard de Matrícula',
            'alumne' => $alumne,
            'matricula' => $matricula,
            'tutors' => $tutors,
            'serveis' => $serveis
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="resguard_' . $alumne->dni . '.pdf"')
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

    public function contacte($id)
    {
        $model = new AlumneModel();
        $tutorModel = new AlumneTutorLegalModel();
        $alumne = $model->getContactePerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $tutors = $tutorModel->getTutorsPerAlumne($id);
        $esMenor = false;
        if (!empty($alumne->data_naixement)) {
            $naixement = new \DateTime($alumne->data_naixement);
            $edat = $naixement->diff(new \DateTime())->y;
            $esMenor = ($edat < 18);
        }

        return view('alumnes/contacte', [
            'title' => 'Contacte alumne',
            'alumne' => $alumne,
            'tutors' => $tutors,
            'esMenor' => $esMenor,
        ]);
    }

    public function enviar_correu($id)
    {
        $model = new AlumneModel();
        $tutorModel = new AlumneTutorLegalModel();
        $alumne = $model->getContactePerId($id);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $tutors = $tutorModel->getTutorsPerAlumne($id);
        $request = service('request');
        $motiu = $request->getPost('motiu');
        $missatge = $request->getPost('missatge');
        $dest = $request->getPost('destinatari');

        $esMenor = false;
        if (!empty($alumne->data_naixement)) {
            $naixement = new \DateTime($alumne->data_naixement);
            $edat = $naixement->diff(new \DateTime())->y;
            $esMenor = ($edat < 18);
        }

        $adreces = [];
        if (!empty($tutors)) {
            if ($dest === 'alumne') {
                if (!empty($alumne->email))
                    $adreces[] = $alumne->email;
            } elseif ($dest === 'tutor_0' && isset($tutors[0]) && !empty($tutors[0]->email)) {
                $adreces[] = $tutors[0]->email;
            } elseif ($dest === 'tutor_1' && isset($tutors[1]) && !empty($tutors[1]->email)) {
                $adreces[] = $tutors[1]->email;
            } else {
                if (!empty($alumne->email))
                    $adreces[] = $alumne->email;
                foreach ($tutors as $tutor) {
                    if (!empty($tutor->email))
                        $adreces[] = $tutor->email;
                }
            }
        } else {
            if (!empty($alumne->email))
                $adreces[] = $alumne->email;
        }

        if (empty($adreces)) {
            return redirect()->to(base_url('alumnes/contacte/' . $id))->with('error', 'No hi ha cap adreça de correu disponible per enviar.');
        }

        $dades = [
            'alumne' => $alumne,
            'motiu' => $motiu,
            'missatge' => $missatge,
        ];

        $email = \Config\Services::email();
        $emailUser = getenv('email.SMTPUser') ?: 'noreply@caparrella.cat';

        $email->setFrom($emailUser, 'SECRETARIA INSTITUT CAPARRELLA');
        $email->setTo($adreces);
        $email->setSubject('Avís de Secretaria Institut Caparrella: ' . $motiu);

        $contingutHtml = view('emails/contacte', $dades);
        $email->setMessage($contingutHtml);

        if ($email->send()) {
            return redirect()->to(base_url('alumnes/contacte/' . $id))->with('exit', 'El correu s\'ha enviat correctament.');
        } else {
            $data = $email->printDebugger(['headers', 'subject', 'body']);
            log_message('error', $data);
            return redirect()->to(base_url('alumnes/contacte/' . $id))->with('error', 'Error SMTP. Revisa la configuració (.env).');
        }
    }

    public function actualitzarDadesAlumne($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        $alumneModel = new AlumneModel();
        $alumne = $alumneModel->find($binaryId);

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        $rules = [
            'nom'      => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'cognom1'  => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'cognom2'  => 'permit_empty|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
            'telefon'  => 'permit_empty|regex_match[/^(\+?[0-9]{9,15})$/]',
            'telefon2' => 'permit_empty|regex_match[/^(\+?[0-9]{9,15})$/]',
        ];

        $missatges = [
            'nom'      => ['regex_match' => 'El nom només pot contenir lletres, espais, guions o apòstrofs.'],
            'cognom1'  => ['regex_match' => 'El primer cognom només pot contenir lletres, espais, guions o apòstrofs.'],
            'cognom2'  => ['regex_match' => 'El segon cognom només pot contenir lletres, espais, guions o apòstrofs.'],
            'telefon'  => ['regex_match' => 'El format del telèfon de l\'alumne no és vàlid (mínim 9 números).'],
            'telefon2' => ['regex_match' => 'El format del telèfon 2 de l\'alumne no és vàlid (mínim 9 números).'],
        ];

        if (!$this->validate($rules, $missatges)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dades = [
            'nom' => $this->request->getPost('nom'),
            'cognom1' => $this->request->getPost('cognom1'),
            'cognom2' => $this->request->getPost('cognom2'),
            'dni' => $this->request->getPost('dni'),
            'data_naixement' => $this->request->getPost('data_naixement'),
            'email' => $this->request->getPost('email'),
            'telefon' => $this->request->getPost('telefon'),
            'telefon2' => $this->request->getPost('telefon2'),
            'carrer' => $this->request->getPost('carrer'),
            'numero' => $this->request->getPost('numero'),
            'poblacio' => $this->request->getPost('poblacio'),
            'nacionalitat' => $this->request->getPost('nacionalitat'),
        ];

        $alumneModel->update($binaryId, $dades);

        return redirect()->to(base_url('alumnes/expedient/' . $id))->with('exit', 'Dades de l\'alumne actualitzades correctament.');
    }
}