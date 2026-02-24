<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecció de Cicle</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=DM+Serif+Display&display=swap"
        rel="stylesheet">

    <!-- CSS personalitzat -->
    <link rel="stylesheet" href="<?= base_url('assets/forms.css') ?>">
</head>

<body>
    <div class="background-decoration"></div>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1 class="form-title">Continuïtat / Reinscripció</h1>
                <p class="form-subtitle">Selecciona el cicle formatiu</p>
            </div>

            <form id="cicleForm">

                <!-- Selecció de Curs -->
                <div class="section-divider">
                    <span class="section-title">Cicle</span>
                </div>

                <div class="mb-5">
                    <div class="course-options">
                        <div class="course-card">
                            <input type="radio" class="btn-check" name="curs" id="curs1" autocomplete="off">
                            <label class="course-label" for="curs1">
                                <div class="course-title">1r Curs</div>
                            </label>
                        </div>

                        <div class="course-card">
                            <input type="radio" class="btn-check" name="curs" id="curs2" autocomplete="off">
                            <label class="course-label" for="curs2">
                                <div class="course-title">2n Curs</div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Opcions addicionals -->
                <div class="section-divider">
                    <span class="section-title">Requisits i Observacions</span>
                </div>

                <div class="mb-4">
                    <div class="form-check checkbox-custom">
                        <input class="form-check-input" type="checkbox" id="acceptacioMatricula">
                        <label class="form-check-label" for="acceptacioMatricula">
                            Accepto matricular-me als mòduls superats de primer
                        </label>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="form-check checkbox-custom">
                        <input class="form-check-input" type="checkbox" id="matriculacioModuls">
                        <label class="form-check-label" for="matriculacioModuls">
                            Matricular-se mòduls sueltos
                        </label>
                    </div>
                </div>

                <!-- Resguard de Notes -->
                <div class="section-divider">
                    <span class="section-title">Documentació</span>
                </div>

                <div class="mb-5">
                    <label for="resguardNotes" class="file-upload-label">
                        <div class="file-upload-box">
                            <div class="file-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <div class="file-upload-text">
                                <strong>Resguard de Notes</strong>
                                <span>Clica per penjar el fitxer o arrossega'l aquí</span>
                                <small>PDF, JPG, PNG (màx. 5MB)</small>
                            </div>
                        </div>
                        <input type="file" class="file-upload-input" id="resguardNotes" accept=".pdf,.jpg,.jpeg,.png">
                    </label>
                    <div class="file-name-display" id="fileNameDisplay"></div>
                </div>

                <!-- Botons -->
                <div class="form-actions">
                    <a href="dadesTutors.php" class="btn btn-anterior btn-lg">Anterior</a>
                    <button type="button" class="btn btn-outline-secondary btn-lg">Guardar</button>
                    <a href="documentacio.php" class="btn btn-primary btn-lg">Següent</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>