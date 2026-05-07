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
        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        // Recollim els tutors com a llista perquè el formulari pugui créixer fins a 3.
        $tutorsInput = $this->request->getPost('tutors') ?? [];
        $errors = [];
        $preparedTutors = [];

        foreach ($tutorsInput as $index => $tutorInput) {
            $nom = trim((string)($tutorInput['nom'] ?? ''));
            $cognoms = trim((string)($tutorInput['cognoms'] ?? ''));
            $telefonPrefix = trim((string)($tutorInput['telefon_prefix'] ?? ''));
            $telefon = preg_replace('/[^0-9]/', '', (string)($tutorInput['telefon'] ?? ''));
            $correu = strtolower(trim((string)($tutorInput['correu'] ?? '')));
            $dniTutor = $this->normalizeDocumentNumber((string)($tutorInput['dni'] ?? ''));
            $rol = trim((string)($tutorInput['rol'] ?? 'Pare'));

            $hasAnyValue = $nom !== '' || $cognoms !== '' || $telefon !== '' || $correu !== '' || $dniTutor !== '';
            $isFirstTutor = $index === 0;

            if (!$hasAnyValue && !$isFirstTutor) {
                continue;
            }

            if ($nom === '' || mb_strlen($nom) < 2) {
                $errors[] = 'El nom del tutor ' . ($index + 1) . ' és obligatori.';
            }
            if ($cognoms === '' || mb_strlen($cognoms) < 2) {
                $errors[] = 'Els cognoms del tutor ' . ($index + 1) . ' són obligatoris.';
            }
            if ($telefonPrefix === '' || !preg_match('/^\\+\\d{1,4}$/', $telefonPrefix)) {
                $errors[] = 'El prefix del telèfon del tutor ' . ($index + 1) . ' no és vàlid.';
            }
            if ($telefon === '' || mb_strlen($telefon) < 6 || mb_strlen($telefon) > 15) {
                $errors[] = 'El número de telèfon del tutor ' . ($index + 1) . ' no és vàlid.';
            }
            if ($correu === '' || !filter_var($correu, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El correu del tutor ' . ($index + 1) . ' no és vàlid.';
            }
            if ($dniTutor === '' || !$this->isValidDniNie($dniTutor)) {
                $errors[] = 'El DNI/NIE del tutor ' . ($index + 1) . ' no és vàlid.';
            }

            [$cognom1, $cognom2] = $this->splitTutorCognoms($cognoms);
            $preparedTutors[] = [
                'nom'       => $nom,
                'cognom1'   => $cognom1,
                'cognom2'   => $cognom2,
                'telefon'   => trim($telefonPrefix . ' ' . $telefon),
                'email'     => $correu,
                'dni'       => $dniTutor,
                'rol'       => $rol !== '' ? $rol : 'Tutor legal',
            ];
        }

        if (empty($preparedTutors)) {
            $errors[] = 'Has d\'informar almenys un pare, mare o tutor legal.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Esborrem els tutors anteriors i recreem l'estat actual del formulari.
        $existingTutors = $this->tutorModel->getByAlumne($alumne['id_alumne']);
        foreach ($existingTutors as $existingTutor) {
            $this->tutorModel->delete($existingTutor['id_tutor']);
        }

        $tutorCount = count($preparedTutors);
        $custodiaBase = $tutorCount > 0 ? intdiv(100, $tutorCount) : 100;
        $remainder = 100 - ($custodiaBase * $tutorCount);

        foreach ($preparedTutors as $index => $preparedTutor) {
            $custodiaPercentatge = $custodiaBase + ($index === 0 ? $remainder : 0);
            $this->tutorModel->insert([
                'id_alumne'            => $alumne['id_alumne'],
                'nom'                  => $preparedTutor['nom'],
                'cognom1'              => $preparedTutor['cognom1'],
                'cognom2'              => $preparedTutor['cognom2'],
                'telefon'              => $preparedTutor['telefon'],
                'email'                => $preparedTutor['email'],
                'dni'                  => $preparedTutor['dni'],
                'rol'                  => $preparedTutor['rol'],
                'custodia_percentatge' => $custodiaPercentatge,
            ]);
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
        $inscripcioMeta = $this->extractInscripcioMetadata($inscripcio);

        // Dades del CSV per a aquest alumne
        $alumneCSV   = $this->csvData->getAlumneByDni($alumne['dni']);
        $assignatures = [];
        $estuiTipus  = '';
        $estudiNivell = '';
        $idEstudi = null;
        $optatives = [];

        if ($alumneCSV) {
            $estuiTipus   = $alumneCSV['estudi_tipus'];
            $estudiNivell = $alumneCSV['estudi_nivell'];
            $assignatures = $alumneCSV['assignatures'];
            $idEstudi = $this->resolveEstudiId($estuiTipus, $estudiNivell);
            $optatives = $idEstudi ? $this->getOptativesByEstudiId($idEstudi) : [];
        }

        $isCicle = $this->isCicleFormatiu($estuiTipus);

        return view('formsviews/dadesCicle', [
            'title'        => 'Dades del Cicle',
            'inscripcio'   => $inscripcio,
            'inscripcio_meta' => $inscripcioMeta,
            'estudi_tipus' => $estuiTipus,
            'estudi_nivell' => $estudiNivell,
            'assignatures' => $assignatures,
            'optatives'    => $optatives,
            'is_cicle'     => $isCicle,
        ]);
    }

    public function saveDadesCicle()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $alumneCSV   = $this->csvData->getAlumneByDni($alumne['dni']);
        $estudiTipus = $alumneCSV['estudi_tipus']  ?? '';
        $estudiNivell = $alumneCSV['estudi_nivell'] ?? '';
        $id_estudi   = $this->resolveEstudiId($estudiTipus, $estudiNivell) ?? 1;
        $isCicle     = $this->isCicleFormatiu($estudiTipus);

        $optativesDisponibles = $id_estudi ? $this->getOptativesByEstudiId($id_estudi) : [];
        $optativa1 = trim((string)$this->request->getPost('optativa_1'));
        $optativa2 = trim((string)$this->request->getPost('optativa_2'));
        $optativa3 = trim((string)$this->request->getPost('optativa_3'));
        $matriculacioModuls = $isCicle && $this->request->getPost('matriculacio_moduls') ? true : false;
        $errors = [];

        if (!empty($optativesDisponibles)) {
            $selectedOptatives = array_values(array_filter([$optativa1, $optativa2, $optativa3], static fn($value) => $value !== ''));
            if (count($selectedOptatives) !== 3) {
                $errors[] = 'Has de seleccionar tres optatives ordenades per prioritat.';
            }
            if (count(array_unique($selectedOptatives)) !== count($selectedOptatives)) {
                $errors[] = 'No pots repetir una mateixa optativa en més d\'una prioritat.';
            }
            foreach ($selectedOptatives as $selectedOptativa) {
                if (!in_array($selectedOptativa, $optativesDisponibles, true)) {
                    $errors[] = 'Una de les optatives seleccionades no és vàlida per a aquest curs.';
                    break;
                }
            }
        }

        $resguard_file = null;
        $file = $this->request->getFile('resguard_notes');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName    = $file->getRandomName();
            $uploadPath = WRITEPATH . 'uploads/resguards/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $file->move($uploadPath, $newName);
            $resguard_file = $newName;
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $data = [
            'id_alumne'            => $alumne['id_alumne'],
            'id_estudi'            => $id_estudi,
            'data'                 => date('Y-m-d'),
            'estat'                => 'esborrany',
            'torn'                 => 1,
        ];

        $existing = $this->inscripcioModel->getByAlumne($alumne['id_alumne']);
        $metadata = $this->extractInscripcioMetadata($existing);
        $metadata['cicle'] = [
            'optativa_1' => $optativa1,
            'optativa_2' => $optativa2,
            'optativa_3' => $optativa3,
            'matriculacio_moduls' => $matriculacioModuls,
            'resguard_notes' => $resguard_file ?: (($metadata['cicle']['resguard_notes'] ?? null) ?: null),
        ];
        $data['observacions'] = $this->encodeInscripcioMetadata($metadata);

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
        $inscripcioMeta = $this->extractInscripcioMetadata($inscripcio);
        return view('formsviews/documentacio', [
            'title' => 'Documentació',
            'inscripcio' => $inscripcio,
            'inscripcio_meta' => $inscripcioMeta,
        ]);
    }

    public function saveDocumentacio()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $alumne = $this->getCurrentAlumne();
        if (!$alumne) return redirect()->to('/auth/login')->with('error', 'Sessió no vàlida');

        $docNum  = $this->normalizeDocumentNumber($this->request->getPost('dni') ?? '');
        $docType = strtoupper(trim($this->request->getPost('doc_tipus') ?? ''));

        $errors = [];

        // Compatibilitat: si no arriba el selector, intentem inferir.
        if ($docType === '') {
            if ($this->isValidNIE($docNum)) {
                $docType = 'NIE';
            } elseif ($this->isValidDni($docNum)) {
                $docType = 'DNI';
            } else {
                $docType = 'DNI';
            }
        }

        // 1) Validació de format (DNI/NIE) o buidatge mínim (PASSAPORT)
        switch ($docType) {
            case 'DNI':
                if (!$this->isValidDni($docNum)) {
                    $errors[] = 'El DNI que has introduït no és vàlid.';
                }
                break;
            case 'NIE':
                if (!$this->isValidNIE($docNum)) {
                    $errors[] = 'El NIE que has introduït no és vàlid.';
                }
                break;
            case 'PASSAPORT':
                if ($docNum === '') {
                    $errors[] = 'El passaport és obligatori.';
                }
                break;
            default:
                $errors[] = 'Tipus de document no vàlid.';
                break;
        }

        // 2) Validació contra la "BBDD" (CSV): només mirem si està registrat.
        if (empty($errors)) {
            $alumneCSV = $this->csvData->getAlumneByDni($docNum);
            if (!$alumneCSV) {
                $errors[] = 'No hi ha cap alumne registrat amb aquest document. Espereu el vostre torn.';
            } else {
                // Per la regla demanada, només cal que consti a la BBDD/CSV.
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $uploadPath = WRITEPATH . 'uploads/documents/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $documentFiles = [];
        $files = ['dni_cara_a', 'dni_cara_b', 'targeta_cara_a', 'targeta_cara_b'];

        foreach ($files as $fileKey) {
            $file = $this->request->getFile($fileKey);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);
                $documentFiles[$fileKey] = $newName;
            }
        }

        $inscripcio = $this->inscripcioModel->getByAlumne($alumne['id_alumne']);
        if (!$inscripcio) {
            return redirect()->back()->withInput()->with('errors', ['No s’ha trobat la matrícula. Torna enrere.']);
        }

        $metadata = $this->extractInscripcioMetadata($inscripcio);
        $previousDocumentacio = $metadata['documentacio'] ?? [];
        $metadata['documentacio'] = array_merge($previousDocumentacio, $documentFiles, [
            'doc_tipus' => $docType,
            'dni' => $docNum,
            'targeta_sanitaria' => trim((string)$this->request->getPost('targeta_sanitaria')),
        ]);

        $data = [
            'observacions' => $this->encodeInscripcioMetadata($metadata),
        ];

        $this->inscripcioModel->update($inscripcio['id_matricula'], $data);

        if ($this->request->getPost('save_draft')) {
            return redirect()->back()->with('success', 'Documents guardats com a esborrany');
        }

        $this->inscripcioModel->update($inscripcio['id_matricula'], ['estat' => 'completat']);
        $this->alumneModel->update($alumne['id_alumne'], ['estat' => 'completat']);

        return redirect()->to('/forms/bonificacions')->with('success', 'Inscripció completada amb èxit!');
    }

    private function normalizeDocumentNumber(string $value): string
    {
        return strtoupper(trim($value));
    }

    /**
     * Divideix un camp de cognoms únic en cognom1 i cognom2.
     */
    private function splitTutorCognoms(string $cognoms): array
    {
        $parts = preg_split('/\s+/', trim($cognoms), 2) ?: [];
        $cognom1 = $parts[0] ?? '';
        $cognom2 = $parts[1] ?? null;

        return [$cognom1, $cognom2];
    }

    /**
     * Considerem cicle formatiu qualsevol estudi que no sigui ESO ni BAT.
     */
    private function isCicleFormatiu(string $estudiTipus): bool
    {
        return !in_array(strtoupper(trim($estudiTipus)), ['ESO', 'BAT'], true);
    }

    /**
     * Busca l'identificador intern de l'estudi a partir del tipus i nivell del CSV.
     */
    private function resolveEstudiId(string $tipus, string $nivell): ?int
    {
        $db = \Config\Database::connect();
        $estudiBDD = $db->table('estudi')
            ->where('tipus', $tipus)
            ->where('nivell', $nivell)
            ->get()
            ->getRowArray();

        return isset($estudiBDD['id_estudi']) ? (int)$estudiBDD['id_estudi'] : null;
    }

    /**
     * Recupera les optatives actives configurades per a un estudi concret.
     */
    private function getOptativesByEstudiId(int $idEstudi): array
    {
        $db = \Config\Database::connect();
        $rows = $db->table('optativa')
            ->select('nom')
            ->where('id_estudi', $idEstudi)
            ->where('estat', 'actiu')
            ->orderBy('nom', 'ASC')
            ->get()
            ->getResultArray();

        return array_values(array_map(static fn(array $row) => $row['nom'], $rows));
    }

    /**
     * Extreu les metadades serialitzades de la matrícula.
     * Si `observacions` encara és un text antic, el preservem com a `legacy_text`.
     */
    private function extractInscripcioMetadata(?array $inscripcio): array
    {
        $rawObservacions = $inscripcio['observacions'] ?? null;
        if (!is_string($rawObservacions) || trim($rawObservacions) === '') {
            return [];
        }

        $decoded = json_decode($rawObservacions, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return ['legacy_text' => $rawObservacions];
    }

    /**
     * Converteix les metadades de formulari a JSON per guardar-les a `observacions`.
     */
    private function encodeInscripcioMetadata(array $metadata): string
    {
        return json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }

    private function isValidDni(string $dni): bool
    {
        $dni = $this->normalizeDocumentNumber($dni);
        if (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
            return false;
        }

        $letrasDni = 'TRWAGMYFPDXBNJZSQVHLCKET';
        $numero = (int)substr($dni, 0, 8);
        $lletraCorrecta = substr($letrasDni, $numero % 23, 1);

        return substr($dni, 8, 1) === $lletraCorrecta;
    }

    private function isValidNIE(string $nie): bool
    {
        $nie = $this->normalizeDocumentNumber($nie);
        if (!preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $nie)) {
            return false;
        }

        $letrasDni = 'TRWAGMYFPDXBNJZSQVHLCKET';
        $map = ['X' => '0', 'Y' => '1', 'Z' => '2'];

        $numeroPrefixat = $map[$nie[0]] . substr($nie, 1, 7); // 8 digits
        $numero = (int)$numeroPrefixat;
        $lletraCorrecta = substr($letrasDni, $numero % 23, 1);

        return substr($nie, 8, 1) === $lletraCorrecta;
    }

    /**
     * Valida un document d'identitat de tipus DNI o NIE (mateixa lògica que `DNIValidator` del frontend).
     */
    private function isValidDniNie(string $document): bool
    {
        $document = $this->normalizeDocumentNumber($document);
        if ($document === '') {
            return false;
        }

        if (preg_match('/^[XYZ]/', $document)) {
            return $this->isValidNIE($document);
        }

        return $this->isValidDni($document);
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
