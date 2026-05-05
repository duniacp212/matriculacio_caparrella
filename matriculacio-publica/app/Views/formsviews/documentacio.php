<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNI i Targeta Sanitària</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Barlow+Condensed:wght@600;700&display=swap"
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

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php
                $sessionDni = strtoupper(trim(session()->get('dni') ?? ''));
                $computedDocTipus = 'DNI';
                if ($sessionDni !== '' && preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $sessionDni)) {
                    $computedDocTipus = 'NIE';
                }
                $selectedDocTipus = old('doc_tipus') ?? $computedDocTipus;
                $dniValue = old('dni') ?? $sessionDni;
            ?>

            <form action="<?= base_url('forms/saveDocumentacio') ?>" method="post" enctype="multipart/form-data" id="documentacioForm">
                <?= csrf_field() ?>

                <!-- Document d'identitat -->
                <div class="section-divider">
                    <span class="section-title">Document d'identitat</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select" id="docTipus" name="doc_tipus" aria-label="Tipus de document">
                                <option value="DNI" <?= $selectedDocTipus === 'DNI' ? 'selected' : '' ?>>DNI</option>
                                <option value="NIE" <?= $selectedDocTipus === 'NIE' ? 'selected' : '' ?>>NIE</option>
                                <option value="PASSAPORT" <?= $selectedDocTipus === 'PASSAPORT' ? 'selected' : '' ?>>Passaport</option>
                            </select>
                            <label for="docTipus">Tipus de document</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control"
                                id="dni"
                                name="dni"
                                placeholder="Número del document"
                                maxlength="20"
                                value="<?= esc($dniValue) ?>">
                            <label for="dni">Número del document</label>
                        </div>
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
                                    <strong>Document - Cara A</strong>
                                    <span>Penja la part frontal</span>
                                </div>
                            </div>
                            <input type="file" class="file-upload-input" id="dniCaraA" name="dni_cara_a" accept=".pdf,.jpg,.jpeg,.png">
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
                                    <strong>Document - Cara B</strong>
                                    <span>Penja la part posterior</span>
                                </div>
                            </div>
                            <input type="file" class="file-upload-input" id="dniCaraB" name="dni_cara_b" accept=".pdf,.jpg,.jpeg,.png">
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
                        <input type="text"
                            class="form-control"
                            id="targetaSanitaria"
                            name="targeta_sanitaria"
                            placeholder="Targeta Sanitària"
                            value="<?= esc(old('targeta_sanitaria') ?? '') ?>">
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
                                name="targeta_cara_a"
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
                                name="targeta_cara_b"
                                accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <div class="file-name-display" id="targetaCaraBDisplay"></div>
                    </div>
                </div>

                <!-- Botons -->
                <div class="form-actions">
                <a href="<?= base_url('forms/dadesCicle') ?>" class="btn btn-anterior btn-lg">Anterior</a>
                <button type="submit" name="save_draft" value="1" class="btn btn-outline-secondary btn-lg">Guardar</button>
                    <button type="submit" class="btn btn-primary btn-lg">Següent</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>