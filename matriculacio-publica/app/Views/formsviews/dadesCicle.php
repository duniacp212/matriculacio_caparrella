<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecció de Cicle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/forms.css') ?>">
</head>

<body>
    <div class="background-decoration"></div>
    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1 class="form-title">Continuïtat / Reinscripció</h1>
                <p class="form-subtitle">Confirma el cicle i les assignatures de la teva matriculació</p>
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

            <form action="<?= base_url('forms/saveDadesCicle') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Cicle assignat (només lectura, ve del CSV) -->
                <div class="section-divider">
                    <span class="section-title">Cicle assignat</span>
                </div>

                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estudi</label>
                            <input type="text" class="form-control" value="<?= esc($estudi_tipus ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Curs</label>
                            <input type="text" class="form-control" value="<?= esc(($estudi_nivell ?? '') . 'r Curs') ?>" readonly>
                            <!-- Camp ocult per enviar el valor al controlador -->
                            <input type="hidden" name="curs" value="<?= esc($estudi_nivell ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Assignatures del curs (llegides del CSV) -->
                <?php if (!empty($assignatures)): ?>
                <div class="section-divider">
                    <span class="section-title">Assignatures del curs</span>
                </div>

                <div class="mb-4">
                    <p class="text-muted small mb-3">Les assignatures següents corresponen al teu cicle i curs, tal com consten al fitxer de matriculació.</p>
                    <div class="row g-2">
                        <?php foreach ($assignatures as $assignatura): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-success flex-shrink-0"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span class="small"><?= esc($assignatura) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Opcions addicionals -->
                <div class="section-divider">
                    <span class="section-title">Requisits i Observacions</span>
                </div>

                <div class="mb-4">
                    <div class="form-check checkbox-custom">
                        <input class="form-check-input" type="checkbox" name="acceptacio_matricula" id="acceptacioMatricula"
                            <?= !empty($inscripcio['acceptacio_matricula']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="acceptacioMatricula">
                            Accepto matricular-me als mòduls suspessos de primer
                        </label>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="form-check checkbox-custom">
                        <input class="form-check-input" type="checkbox" name="matriculacio_moduls" id="matriculacioModuls"
                            <?= !empty($inscripcio['matriculacio_moduls']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="matriculacioModuls">
                            Matricular-se mòduls solts
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <input type="file" class="file-upload-input" id="resguardNotes" name="resguard_notes" accept=".pdf,.jpg,.jpeg,.png">
                    </label>
                    <div class="file-name-display" id="fileNameDisplay"></div>
                </div>

                <!-- Botons -->
                <div class="form-actions">
                    <a href="<?= base_url('forms/dadesTutors') ?>" class="btn btn-anterior btn-lg">Anterior</a>

                    <button type="submit" name="save_draft" value="1" class="btn btn-outline-secondary btn-lg">Guardar</button>

                    <button type="submit" class="btn btn-primary btn-lg">Següent</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostra el nom del fitxer seleccionat
        document.getElementById('resguardNotes').addEventListener('change', function () {
            const display = document.getElementById('fileNameDisplay');
            display.textContent = this.files[0] ? this.files[0].name : '';
        });
    </script>
</body>
</html>
