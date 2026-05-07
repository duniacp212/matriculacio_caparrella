<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="row flex-grow-1 g-0 mt-3">

        <main class="col-12 pt-0 px-3 overflow-auto">

            <div class="d-flex justify-content-start mb-3">
                <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
            </div>

            <?php
            $esMenor = false;
            if (!empty($alumne->data_naixement)) {
                $naixement = new DateTime($alumne->data_naixement);
                $avui = new DateTime();
                $edat = $naixement->diff($avui)->y;
                $esMenor = ($edat < 18);
            }
            ?>

            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-11">

                    <h5 class="mb-4 fw-semibold text-center mt-3">
                        <?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?> <?= esc($alumne->cognom2) ?>
                        · DNI <?= esc($alumne->dni) ?>
                    </h5>

                    <?php if (session()->getFlashdata('exit')): ?>
                        <div class="alert alert-success py-2 text-center"><?= session()->getFlashdata('exit') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2 text-center"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form id="formMatricula" method="post"
                        action="<?= base_url('matricules/actualitzar/' . $matricula->id_matricula) ?>">
                        <?= csrf_field() ?>
                    </form>

                    <div class="accordion mb-4 card-lila" id="accordionMatricula">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#dadesPersonals">
                                    Dades personals i d'adreça
                                </button>
                            </h2>
                            <div id="dadesPersonals" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="row g-0">
                                        <div class="col-md-6 pe-md-3">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Nom</label>
                                                <input type="text" name="nom" class="form-control" form="formMatricula"
                                                    value="<?= esc($alumne->nom) ?>" disabled required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Primer cognom</label>
                                                <input type="text" name="cognom1" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->cognom1) ?>" disabled
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Segon cognom</label>
                                                <input type="text" name="cognom2" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->cognom2 ?? '—') ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">DNI / NIE</label>
                                                <input type="text" name="dni" class="form-control" form="formMatricula"
                                                    value="<?= esc($alumne->dni) ?>" disabled required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Data de naixement</label>
                                                <input type="date" name="data_naixement" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->data_naixement) ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Lloc de naixement</label>
                                                <input type="text" name="lloc_naixement" class="form-control"
                                                    form="formMatricula"
                                                    value="<?= esc($alumne->lloc_naixement ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Nacionalitat</label>
                                                <input type="text" name="nacionalitat" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->nacionalitat ?? '') ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ps-md-3 border-start">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Telèfon</label>
                                                <input type="text" name="telefon" class="form-control"
                                                    form="formMatricula"
                                                    value="<?= !empty($alumne->telefon) ? esc($alumne->telefon) : '—' ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Telèfon 2</label>
                                                <input type="text" name="telefon2" class="form-control"
                                                    form="formMatricula"
                                                    value="<?= !empty($alumne->telefon2) ? esc($alumne->telefon2) : '—' ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Correu electrònic</label>
                                                <input type="email" name="email" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->email ?? '') ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Carrer</label>
                                                <input type="text" name="carrer" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->carrer ?? '') ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Número</label>
                                                <input type="text" name="numero" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->numero ?? '') ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Pis</label>
                                                <input type="text" name="pis" class="form-control" form="formMatricula"
                                                    value="<?= esc($alumne->pis ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Codi postal</label>
                                                <input type="text" name="codi_postal" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->codi_postal ?? '') ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Població</label>
                                                <input type="text" name="poblacio" class="form-control"
                                                    form="formMatricula" value="<?= esc($alumne->poblacio ?? '') ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#dadesAcademiques">
                                    Dades acadèmiques i de matrícula
                                </button>
                            </h2>
                            <div id="dadesAcademiques" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="row g-0">
                                        <div class="col-md-6 pe-md-3">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Estudi</label>
                                                <input class="form-control" value="<?= esc($matricula->tipus) ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Curs</label>
                                                <?php
                                                $c = $matricula->nivell;
                                                $sufix = is_numeric($c) ? ($c == 1 ? 'r' : ($c == 2 ? 'n' : ($c == 3 ? 'r' : 't'))) : '';
                                                ?>
                                                <input class="form-control" value="<?= esc($c . $sufix) ?> curs"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Torn</label>
                                                <select name="torn" class="form-select" form="formMatricula" disabled>
                                                    <option value="1" <?= $matricula->torn == 1 ? 'selected' : '' ?>>
                                                        Torn 1</option>
                                                    <option value="2" <?= $matricula->torn == 2 ? 'selected' : '' ?>>
                                                        Torn 2</option>
                                                    <option value="3" <?= $matricula->torn == 3 ? 'selected' : '' ?>>
                                                        Torn 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ps-md-3 border-start">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Estat</label>
                                                <input class="form-control" value="<?= esc($matricula->estat) ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Data pagament</label>
                                                <div class="fw-semibold">
                                                    <?php if (!empty($matricula->data_pagament)): ?>
                                                        <span
                                                            class="text-success"><?= esc($matricula->data_pagament) ?></span>
                                                    <?php else: ?>
                                                        <span class="text-danger">No pagat</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Bonificació</label>
                                                <select name="id_bonificacio" class="form-select fw-semibold" form="formMatricula" disabled>
                                                    <option value="">Sense bonificació</option>
                                                    <?php foreach ($bonificacions as $boni): ?>
                                                        <option value="<?= esc($boni['id_bonificacio']) ?>" <?= ($matricula->id_bonificacio == $boni['id_bonificacio']) ? 'selected' : '' ?>>
                                                            <?= esc($boni['tipus']) ?> (<?= esc($boni['percentatge']) ?>%)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Serveis contractats</label>
                                                <div class="mt-1">
                                                    <?php
                                                    $idsContractats = array_column($serveisContractats, 'id_servei');
                                                    if (!empty($serveis)):
                                                        foreach ($serveis as $servei): ?>
                                                            <div class="form-check mb-1">
                                                                <input class="form-check-input" type="checkbox" name="serveis[]"
                                                                    value="<?= esc($servei['id_servei']) ?>"
                                                                    id="servei_<?= esc($servei['id_servei']) ?>" form="formMatricula"
                                                                    <?= in_array($servei['id_servei'], $idsContractats) ? 'checked' : '' ?> disabled>
                                                                <label class="form-check-label text-dark small"
                                                                    for="servei_<?= esc($servei['id_servei']) ?>">
                                                                    <?= esc($servei['tipus']) ?> (<?= esc($servei['preu']) ?>€)
                                                                </label>
                                                            </div>
                                                        <?php endforeach;
                                                    else: ?>
                                                        <span class="text-muted small">No hi ha serveis disponibles.</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#tutors">
                                    Tutors legals
                                </button>
                            </h2>
                            <div id="tutors" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <?php if (!empty($tutors)): ?>
                                        <?php foreach ($tutors as $idx => $tutor): ?>
                                            <input type="hidden" name="tutor_id[]" value="<?= esc($tutor->id_tutor) ?>"
                                                form="formMatricula">
                                            <div
                                                class="row g-0 mb-4 pb-3 <?= ($idx < count($tutors) - 1) ? 'border-bottom' : '' ?>">
                                                <div class="col-md-6 pe-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Nom</label>
                                                        <input type="text" name="tutor_nom[]" class="form-control"
                                                            form="formMatricula" value="<?= esc($tutor->nom) ?>" disabled
                                                            <?= ($idx === 0 && $esMenor) ? 'required' : '' ?>>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Primer cognom</label>
                                                        <input type="text" name="tutor_cognom1[]" class="form-control"
                                                            form="formMatricula" value="<?= esc($tutor->cognom1) ?>" disabled
                                                            <?= ($idx === 0 && $esMenor) ? 'required' : '' ?>>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">DNI</label>
                                                        <input type="text" name="tutor_dni[]" class="form-control"
                                                            form="formMatricula" value="<?= esc($tutor->dni) ?>" disabled
                                                            <?= ($idx === 0 && $esMenor) ? 'required' : '' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 ps-md-3 border-start">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Rol</label>
                                                        <input type="text" name="tutor_rol[]" class="form-control"
                                                            form="formMatricula" value="<?= esc($tutor->rol) ?>" disabled
                                                            <?= ($idx === 0 && $esMenor) ? 'required' : '' ?>>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Telèfon</label>
                                                        <input type="text" name="tutor_telefon[]" class="form-control"
                                                            form="formMatricula" value="<?= esc($tutor->telefon) ?>" disabled
                                                            <?= ($idx === 0 && $esMenor) ? 'required' : '' ?>>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Email</label>
                                                        <input type="email" name="tutor_email[]" class="form-control"
                                                            form="formMatricula" value="<?= esc($tutor->email) ?>" disabled
                                                            <?= ($idx === 0 && $esMenor) ? 'required' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No hi ha tutors registrats.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#observacions">
                                    Observacions de l'alumne
                                </button>
                            </h2>
                            <div id="observacions" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row g-0">
                                        <div class="col-md-6 pe-md-3">
                                            <p class="text-muted small">Aquestes observacions han estat introduïdes per
                                                l'alumne durant el procés d'auto-matrícula.</p>
                                        </div>
                                        <div class="col-md-6 ps-md-3 border-start">
                                            <label class="form-label text-muted small fw-semibold">Comentaris de
                                                l'alumne</label>
                                            <?php
                                            $historialM = !empty($matricula->observacions_matricula) ? json_decode($matricula->observacions_matricula, true) : [];
                                            if (!empty($matricula->observacions_matricula) && !is_array($historialM)) {
                                                $historialM = [['id' => 'legacy', 'data' => null, 'text' => $matricula->observacions_matricula]];
                                            }
                                            ?>

                                            <?php if (!empty($historialM)): ?>
                                                <div class="list-group list-group-flush border">
                                                    <?php foreach (array_reverse($historialM) as $obs): ?>
                                                        <div class="list-group-item py-2 bg-white">
                                                            <?php if (isset($obs['data'])): ?>
                                                                <small
                                                                    class="text-secondary small d-block"><?= date('d/m/Y H:i', strtotime($obs['data'])) ?></small>
                                                            <?php endif; ?>
                                                            <p class="mb-0 text-muted small" style="white-space: pre-line;">
                                                                <?= esc($obs['text'] ?? $obs) ?>
                                                            </p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted small text-center mb-0">L'alumne no ha deixat cap
                                                    observació en el formulari de matrícula.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#documentsMatricula">
                                    Documents adjunts a la matrícula
                                </button>
                            </h2>
                            <div id="documentsMatricula" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <?php if (!empty($documents)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-sm mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Tipus</th>
                                                        <th>Nom del fitxer</th>
                                                        <th>Data pujada</th>
                                                        <th style="width: 100px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($documents as $doc): ?>
                                                        <tr>
                                                            <td><?= esc($doc->tipus ?? '—') ?></td>
                                                            <td><?= esc($doc->nom_original) ?></td>
                                                            <td><?= esc(date('d/m/Y H:i', strtotime($doc->creat_el))) ?></td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url('alumnes/document/' . $doc->id_document) ?>"
                                                                    target="_blank" class="btn btn-outline-primary btn-sm px-3">
                                                                    Veure
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted text-center mb-0">No s'han adjuntat documents en aquesta
                                            matrícula.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-between align-items-center mt-4 mb-5 border-top pt-3">
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('alumnes/pdf-matricula/' . $matricula->id_matricula) ?>"
                                target="_blank" class="btn btn-outline-danger">Exportar Matrícula (PDF)</a>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" id="btnEditar" class="btn btn-outline-primary">Editar dades</button>
                            <button type="submit" id="btnGuardar" form="formMatricula"
                                class="btn btn-primary d-none">Guardar canvis</button>
                            <button type="button" id="btnCancel·lar"
                                class="btn btn-outline-secondary d-none">Cancel·lar</button>
                            <?php if (!$matricula->data_pagament): ?>
                                <a href="<?= base_url('matricules/marcar-pagat/' . $matricula->id_matricula) ?>"
                                    class="btn btn-info"
                                    onclick="return confirm('Confirmar que s\'ha realitzat el pagament?')">
                                    Marcar com a Pagat
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('matricules/marcar-pendent/' . $matricula->id_matricula) ?>"
                                    class="btn btn-outline-info"
                                    onclick="return confirm('Vols marcar el pagament com a NO pagat?')">
                                    Marcar com a No Pagat
                                </a>
                            <?php endif; ?>

                            <?php if ($matricula->estat !== 'Validat'): ?>
                                <a href="<?= base_url('matricules/validar/' . $matricula->id_matricula) ?>"
                                    class="btn btn-success"
                                    onclick="return confirm('Estàs segur que vols validar aquesta matrícula?')">
                                    Validar matrícula
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('matricules/invalidar/' . $matricula->id_matricula) ?>"
                                    class="btn btn-outline-danger"
                                    onclick="return confirm('Estàs segur que vols invalidar aquesta matrícula? Tornarà a estat Pendent.')">
                                    Invalidar matrícula
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEditar = document.getElementById('btnEditar');
        const btnGuardar = document.getElementById('btnGuardar');
        const btnCancellar = document.getElementById('btnCancel·lar');
        const form = document.getElementById('formMatricula');
        const inputs = document.querySelectorAll('[form="formMatricula"]');

        btnEditar.addEventListener('click', function () {
            inputs.forEach(input => {
                if (input.name !== '' && !input.readOnly) {
                    input.disabled = false;
                    if (input.value === '—') {
                        input.value = '';
                    }
                }
            });
            btnEditar.classList.add('d-none');
            btnGuardar.classList.remove('d-none');
            btnCancellar.classList.remove('d-none');
        });

        btnCancellar.addEventListener('click', function () {
            if (confirm('Estàs segur que vols cancel·lar els canvis? Es perdran les modificacions no guardades.')) {
                window.location.reload();
            }
        });

        form.addEventListener('submit', function (e) {
            if (!confirm('Estàs segur que vols guardar aquests canvis?')) {
                e.preventDefault();
            }
        });
    });
</script>

<?= view('layouts/footer') ?>