<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulari de Dades dels Tutors</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=DM+Serif+Display&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/forms.css') ?>">
</head>

<body>
    <div class="background-decoration"></div>

    <?php
        $existingTutors = [];
        foreach (($tutors ?? []) as $tutor) {
            $rawTelefon = (string)($tutor['telefon'] ?? '');
            $telefonPrefix = '+34';
            $telefonNumero = $rawTelefon;

            if (preg_match('/^(\\+\\d{1,4})\\s*(.*)$/', trim($rawTelefon), $matches)) {
                $telefonPrefix = $matches[1];
                $telefonNumero = $matches[2];
            }

            $telefonNumero = preg_replace('/[^0-9]/', '', (string)$telefonNumero);

            $existingTutors[] = [
                'rol' => $tutor['rol'] ?? 'Pare',
                'nom' => $tutor['nom'] ?? '',
                'cognoms' => trim(($tutor['cognom1'] ?? '') . ' ' . ($tutor['cognom2'] ?? '')),
                'telefon_prefix' => $telefonPrefix,
                'telefon' => $telefonNumero,
                'correu' => $tutor['email'] ?? '',
                'dni' => $tutor['dni'] ?? '',
            ];
        }

        $tutorsData = old('tutors') ?? $existingTutors;
        if (empty($tutorsData)) {
            $tutorsData = [[
                'rol' => 'Pare',
                'nom' => '',
                'cognoms' => '',
                'dni' => '',
                'telefon_prefix' => '+34',
                'telefon' => '',
                'correu' => '',
            ]];
        }

        $visibleTutors = max(1, min(3, count($tutorsData)));

        while (count($tutorsData) < 3) {
            $tutorsData[] = [
                'rol' => 'Pare',
                'nom' => '',
                'cognoms' => '',
                'dni' => '',
                'telefon_prefix' => '+34',
                'telefon' => '',
                'correu' => '',
            ];
        }
    ?>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1 class="form-title">Dades dels Tutors</h1>
                <p class="form-subtitle">Informació del pare, mare o tutor legal</p>
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

            <form action="<?= base_url('forms/saveDadesTutors') ?>" method="post" id="tutorsForm">
                <?= csrf_field() ?>

                <p class="text-muted small mb-4">Cal informar almenys un tutor. En pots afegir fins a tres.</p>

                <?php for ($i = 0; $i < 3; $i++): ?>
                    <?php
                        $tutor = $tutorsData[$i];
                        $isVisible = $i < $visibleTutors;
                    ?>
                    <div class="tutor-block <?= $isVisible ? '' : 'd-none' ?>">
                        <div class="section-divider">
                            <span class="section-title"><?= $i === 0 ? 'Tutor obligatori' : 'Tutor ' . ($i + 1) ?></span>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="rolTutor<?= $i ?>" name="tutors[<?= $i ?>][rol]">
                                        <option value="Pare" <?= ($tutor['rol'] ?? '') === 'Pare' ? 'selected' : '' ?>>Pare</option>
                                        <option value="Mare" <?= ($tutor['rol'] ?? '') === 'Mare' ? 'selected' : '' ?>>Mare</option>
                                        <option value="Tutor legal" <?= ($tutor['rol'] ?? '') === 'Tutor legal' ? 'selected' : '' ?>>Tutor legal</option>
                                    </select>
                                    <label for="rolTutor<?= $i ?>">Tipus de tutor</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nomTutor<?= $i ?>"
                                        name="tutors[<?= $i ?>][nom]" placeholder="Nom"
                                        value="<?= esc($tutor['nom'] ?? '') ?>">
                                    <label for="nomTutor<?= $i ?>">Nom</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cognomsTutor<?= $i ?>"
                                        name="tutors[<?= $i ?>][cognoms]" placeholder="Cognoms"
                                        value="<?= esc($tutor['cognoms'] ?? '') ?>">
                                    <label for="cognomsTutor<?= $i ?>">Cognoms</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="dniTutor<?= $i ?>"
                                        name="tutors[<?= $i ?>][dni]" placeholder="DNI/NIE"
                                        maxlength="9"
                                        value="<?= esc($tutor['dni'] ?? '') ?>">
                                    <label for="dniTutor<?= $i ?>">DNI / NIE del tutor</label>
                                </div>
                                <div class="invalid-feedback" id="dniTutor<?= $i ?>Feedback"></div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="correuTutor<?= $i ?>"
                                        name="tutors[<?= $i ?>][correu]" placeholder="Correu"
                                        value="<?= esc($tutor['correu'] ?? '') ?>">
                                    <label for="correuTutor<?= $i ?>">Correu electrònic</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-5">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control tutor-prefix"
                                                id="telefonPrefixTutor<?= $i ?>"
                                                name="tutors[<?= $i ?>][telefon_prefix]"
                                                placeholder="+34"
                                                maxlength="5"
                                                value="<?= esc($tutor['telefon_prefix'] ?? '+34') ?>">
                                            <label for="telefonPrefixTutor<?= $i ?>">Prefix</label>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control tutor-phone" id="telefonTutor<?= $i ?>"
                                                name="tutors[<?= $i ?>][telefon]" placeholder="Telèfon"
                                                maxlength="9"
                                                value="<?= esc($tutor['telefon'] ?? '') ?>">
                                            <label for="telefonTutor<?= $i ?>">Telèfon</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>

                <div class="mb-4">
                    <button type="button" class="btn btn-outline-primary" id="addTutorButton">Afegir tutor</button>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('forms/dadesPersonals') ?>" class="btn btn-anterior btn-lg">Anterior</a>
                    <button type="submit" name="save_draft" value="1" class="btn btn-outline-secondary btn-lg">Guardar</button>
                    <button type="submit" class="btn btn-primary btn-lg">Següent</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dni-validator.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tutorBlocks = Array.from(document.querySelectorAll('.tutor-block'));
            const addTutorButton = document.getElementById('addTutorButton');

            function updateButtonState() {
                const hasHiddenBlock = tutorBlocks.some(block => block.classList.contains('d-none'));
                addTutorButton.disabled = !hasHiddenBlock;
            }

            addTutorButton.addEventListener('click', function () {
                const nextHiddenBlock = tutorBlocks.find(block => block.classList.contains('d-none'));
                if (nextHiddenBlock) {
                    nextHiddenBlock.classList.remove('d-none');
                    updateButtonState();
                }
            });

            updateButtonState();

            // Telèfon: només dígits
            document.querySelectorAll('.tutor-phone').forEach((input) => {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            // Prefix: input lliure però sempre amb '+' i només dígits darrere.
            document.querySelectorAll('.tutor-prefix').forEach((input) => {
                input.addEventListener('input', function () {
                    let value = this.value.replace(/[^0-9+]/g, '');

                    // Només permetem un '+' al principi
                    value = value.replace(/\+/g, '');
                    value = '+' + value;

                    this.value = value.slice(0, 5); // ex: +1234
                });

                input.addEventListener('blur', function () {
                    if (!this.value.startsWith('+')) {
                        this.value = '+' + this.value.replace(/[^0-9]/g, '');
                    }
                    if (this.value === '+') {
                        this.value = '+34';
                    }
                });
            });

            // DNI/NIE: validació en temps real amb DNIValidator
            for (let i = 0; i < 3; i++) {
                const dniInput = document.getElementById(`dniTutor${i}`);
                const feedback = document.getElementById(`dniTutor${i}Feedback`);
                if (!dniInput || !window.DNIValidator) continue;

                DNIValidator.bindToInput(dniInput, (result) => {
                    if (!feedback) return;
                    feedback.textContent = result.valid ? '' : (result.error || 'Document no vàlid');
                });
            }
        });
    </script>
</body>

</html>