<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNI i Targeta Sanitària</title>

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
                <h1 class="form-title">Documentació Personal</h1>
                <p class="form-subtitle">DNI i Targeta Sanitària</p>
            </div>

            <form id="documentacioForm">

                <!-- DNI -->
                <div class="section-divider">
                    <span class="section-title">DNI</span>
                </div>

                <div class="mb-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="dni" placeholder="DNI">
                        <label for="dni">Número de DNI</label>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label for="dniCaraA" class="file-upload-label-compact">
                            <div class="file-upload-box-compact">
                                <div class="file-upload-icon-small">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                </div>
                                <div class="file-upload-text-compact">
                                    <strong>DNI - Cara A</strong>
                                    <span>Penja la part frontal</span>
                                </div>
                            </div>
                            <input type="file" class="file-upload-input" id="dniCaraA" accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <div class="file-name-display" id="dniCaraADisplay"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="dniCaraB" class="file-upload-label-compact">
                            <div class="file-upload-box-compact">
                                <div class="file-upload-icon-small">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                </div>
                                <div class="file-upload-text-compact">
                                    <strong>DNI - Cara B</strong>
                                    <span>Penja la part posterior</span>
                                </div>
                            </div>
                            <input type="file" class="file-upload-input" id="dniCaraB" accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <div class="file-name-display" id="dniCaraBDisplay"></div>
                    </div>
                </div>

                <!-- Targeta Sanitària -->
                <div class="section-divider">
                    <span class="section-title">Targeta Sanitària</span>
                </div>

                <div class="mb-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="targetaSanitaria" placeholder="Targeta Sanitària">
                        <label for="targetaSanitaria">Número de Targeta Sanitària</label>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label for="targetaCaraA" class="file-upload-label-compact">
                            <div class="file-upload-box-compact">
                                <div class="file-upload-icon-small">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                </div>
                                <div class="file-upload-text-compact">
                                    <strong>Targeta - Cara A</strong>
                                    <span>Penja la part frontal</span>
                                </div>
                            </div>
                            <input type="file" class="file-upload-input" id="targetaCaraA"
                                accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <div class="file-name-display" id="targetaCaraADisplay"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="targetaCaraB" class="file-upload-label-compact">
                            <div class="file-upload-box-compact">
                                <div class="file-upload-icon-small">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                </div>
                                <div class="file-upload-text-compact">
                                    <strong>Targeta - Cara B</strong>
                                    <span>Penja la part posterior</span>
                                </div>
                            </div>
                            <input type="file" class="file-upload-input" id="targetaCaraB"
                                accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <div class="file-name-display" id="targetaCaraBDisplay"></div>
                    </div>
                </div>

                <!-- Botons -->
                <div class="form-actions">
                <a href="<?= base_url('forms/dadesCicle') ?>" class="btn btn-anterior btn-lg">Anterior</a>
                <button type="button" class="btn btn-outline-secondary btn-lg">Guardar</button>
                    <a href="<?= base_url('forms/bonificacions') ?>" class="btn btn-primary btn-lg">Següent</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>