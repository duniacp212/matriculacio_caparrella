<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 bg-white">
        <div class="row align-items-center">
            <div class="col-12">
                <h4 class="mb-0"><?= esc($title) ?></h4>
            </div>
        </div>
    </div>

    <div class="row flex-grow-1 g-0 mt-3">

        <main class="col-12 pt-0 px-3 overflow-auto">

            <div class="d-flex justify-content-start mb-3">
                <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
            </div>

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
                        <div class="accordion mb-4 card-lila" id="accordionExpedient">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#dadesPersonals">
                                        Dades personals i d'adreça
                                    </button>
                                </h2>
                                <div id="dadesPersonals" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form id="formExpedient" action="<?= base_url('alumnes/actualitzar-dades/' . $alumne->id_alumne) ?>" method="post">
                                            <?= csrf_field() ?>
                                        </form>
                                        <div class="row g-0">
                                            <div class="col-md-6 pe-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Nom</label>
                                                    <input name="nom" class="form-control" value="<?= esc($alumne->nom) ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Primer cognom</label>
                                                    <input name="cognom1" class="form-control" value="<?= esc($alumne->cognom1) ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Segon cognom</label>
                                                    <input name="cognom2" class="form-control" value="<?= esc($alumne->cognom2 ?? '') ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">DNI</label>
                                                    <input name="dni" class="form-control" value="<?= esc($alumne->dni) ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Data de naixement</label>
                                                    <input name="data_naixement" type="date" class="form-control"
                                                        value="<?= esc($alumne->data_naixement) ?>" form="formExpedient" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ps-md-3 border-start">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Email</label>
                                                    <input name="email" class="form-control" value="<?= esc($alumne->email ?? '') ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Telèfon</label>
                                                    <input name="telefon" class="form-control" value="<?= esc($alumne->telefon ?? '') ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Telèfon 2</label>
                                                    <input name="telefon2" class="form-control" value="<?= esc($alumne->telefon2 ?? '') ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Adreça (Carrer, Número, Població)</label>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <input name="carrer" class="form-control" placeholder="Carrer" value="<?= esc($alumne->carrer ?? '') ?>" form="formExpedient" disabled>
                                                        </div>
                                                        <div class="col-2">
                                                            <input name="numero" class="form-control" placeholder="Núm." value="<?= esc($alumne->numero ?? '') ?>" form="formExpedient" disabled>
                                                        </div>
                                                        <div class="col-4">
                                                            <input name="poblacio" class="form-control" placeholder="Població" value="<?= esc($alumne->poblacio ?? '') ?>" form="formExpedient" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Nacionalitat</label>
                                                    <input name="nacionalitat" class="form-control" value="<?= esc($alumne->nacionalitat ?? '') ?>" form="formExpedient" disabled>
                                                </div>
                                                <div class="text-end mt-4">
                                                    <button type="button" id="btnEditar" class="btn btn-outline-primary btn-sm px-4">Editar dades</button>
                                                    <button type="submit" id="btnGuardar" form="formExpedient" class="btn btn-primary btn-sm px-4 d-none">Guardar canvis</button>
                                                    <button type="button" id="btnCancel·lar" class="btn btn-outline-secondary btn-sm px-4 d-none">Cancel·lar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#historialAcademic">
                                        Historial Acadèmic i Matrícules
                                    </button>
                                </h2>
                                <div id="historialAcademic" class="accordion-collapse collapse">
                                    <div class="accordion-body p-0">
                                        <?php if (!empty($matricules)): ?>
                                            <div class="accordion accordion-flush" id="accordionAnys">
                                                <?php foreach ($matricules as $idx => $m): ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button <?= $idx === 0 ? '' : 'collapsed' ?> bg-light" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#any_<?= $m['any_academic'] ?>_<?= $idx ?>">
                                                                <span class="fw-bold me-2"><?= $m['any_academic'] ?></span> - 
                                                                <?= esc($m['estudi']) ?> 
                                                                (<?php 
                                                                    $c = $m['curs'];
                                                                    $sufix = is_numeric($c) ? ($c == 1 ? 'r' : ($c == 2 ? 'n' : ($c == 3 ? 'r' : 't'))) : '';
                                                                    echo esc($c . $sufix);
                                                                ?> curs)
                                                                <span class="badge ms-2 <?= $m['estat'] === 'Validat' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                                                    <?= esc($m['estat']) ?>
                                                                </span>
                                                            </button>
                                                        </h2>
                                                        <div id="any_<?= $m['any_academic'] ?>_<?= $idx ?>" class="accordion-collapse collapse <?= $idx === 0 ? 'show' : '' ?>">
                                                            <div class="accordion-body">
                                                                <div class="row g-0">
                                                                    <div class="col-md-6 pe-md-3">
                                                                        <label class="form-label text-muted small fw-semibold">Detalls de la matrícula</label>
                                                                        <div class="mb-2">
                                                                            <small class="text-muted">Estat pagament:</small>
                                                                            <span class="<?= $m['data_pagament'] ? 'text-success' : 'text-danger' ?> fw-semibold">
                                                                                <?= $m['data_pagament'] ? 'Pagat (' . date('d/m/Y', strtotime($m['data_pagament'])) . ')' : 'Pendent' ?>
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <small class="text-muted">Torn:</small>
                                                                            <span>Torn <?= $m['torn'] ?></span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <small class="text-muted">Bonificació:</small>
                                                                            <span><?= $m['bonificacio_nom'] ? esc($m['bonificacio_nom']) . ' (' . $m['bonificacio_percentatge'] . '%)' : 'Cap' ?></span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <small class="text-muted">Serveis contractats:</small>
                                                                            <ul class="list-unstyled mb-0">
                                                                                <?php if (!empty($m['serveis'])): ?>
                                                                                    <?php foreach ($m['serveis'] as $s): ?>
                                                                                        <li><span class="badge bg-secondary"><?= esc($s['tipus']) ?></span></li>
                                                                                    <?php endforeach; ?>
                                                                                <?php else: ?>
                                                                                    <li><span>Cap</span></li>
                                                                                <?php endif; ?>
                                                                            </ul>
                                                                        </div>
                                                                        <hr class="my-3">
                                                                        <label class="form-label text-muted small fw-semibold">Tutors legals registrats</label>
                                                                        <?php if (!empty($tutors)): ?>
                                                                            <ul class="list-unstyled mb-0">
                                                                                <?php foreach ($tutors as $t): ?>
                                                                                    <li class="small mb-2 border-bottom pb-1">
                                                                                        <div class="fw-bold"><?= esc($t->nom) ?> <?= esc($t->cognom1) ?> (<?= esc($t->rol) ?>)</div>
                                                                                        <div class="text-muted"><?= esc($t->dni) ?> | <?= esc($t->telefon) ?> | <?= esc($t->email) ?></div>
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        <?php else: ?>
                                                                            <p class="text-muted small">No hi ha tutors registrats.</p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6 ps-md-3 border-start">
                                                                        <label class="form-label text-muted small fw-semibold">Observacions de l'alumne (Matrícula)</label>
                                                                        <?php
                                                                        $obsM = !empty($m['observacions_matricula']) ? json_decode($m['observacions_matricula'], true) : [];
                                                                        if (!empty($m['observacions_matricula']) && !is_array($obsM)) {
                                                                            $obsM = [['data' => $m['data'], 'text' => $m['observacions_matricula']]];
                                                                        }
                                                                        ?>
                                                                        <?php if (!empty($obsM)): ?>
                                                                            <div class="list-group list-group-flush border">
                                                                                <?php foreach (array_reverse($obsM) as $o): ?>
                                                                                    <div class="list-group-item py-2 bg-white">
                                                                                        <?php if (isset($o['data'])): ?>
                                                                                            <small class="text-secondary small d-block"><?= date('d/m/Y H:i', strtotime($o['data'])) ?></small>
                                                                                        <?php endif; ?>
                                                                                        <p class="mb-0 text-muted small" style="white-space: pre-line;"><?= esc($o['text'] ?? $o) ?></p>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        <?php else: ?>
                                                                            <p class="text-muted small">L'alumne no va deixar observacions en aquest curs.</p>
                                                                        <?php endif; ?>

                                                                        <hr class="my-3">
                                                                        <label class="form-label text-muted small fw-semibold">Documents adjunts a la matrícula</label>
                                                                        <?php 
                                                                        $docsAny = array_filter($documents, function($d) use ($m) {
                                                                            return $d->any_academic == $m['any_academic'];
                                                                        });
                                                                        ?>
                                                                        <?php if (!empty($docsAny)): ?>
                                                                            <div class="list-group list-group-flush border">
                                                                                <?php foreach ($docsAny as $d): ?>
                                                                                    <div class="list-group-item py-1 bg-white d-flex justify-content-between align-items-center">
                                                                                        <small class="text-muted"><?= esc($d->tipus ?? 'Altre') ?>: <?= esc($d->nom_original) ?></small>
                                                                                        <a href="<?= base_url('alumnes/document/' . $d->id_document) ?>" target="_blank" class="btn btn-link btn-sm p-0 text-decoration-none">Veure</a>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        <?php else: ?>
                                                                            <p class="text-muted small">No hi ha documents adjunts per aquest curs.</p>
                                                                        <?php endif; ?>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="p-4 text-center text-muted">
                                                No s'ha trobat cap matrícula registrada per aquest alumne.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#observacionsExpedient">
                                        Observacions de l'expedient (Secretaria)
                                    </button>
                                </h2>
                                <div id="observacionsExpedient" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row g-0">
                                            <div class="col-md-6 pe-md-3">
                                                <form method="post" action="<?= base_url('alumnes/actualitzar-observacions-alumne/' . $alumne->id_alumne) ?>">
                                                    <?= csrf_field() ?>
                                                    <label class="form-label text-muted small fw-semibold">Nova observació de l'expedient</label>
                                                    <textarea class="form-control mb-2" name="observacions" rows="4" required></textarea>
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary btn-sm px-4">Afegir a l'expedient</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-6 ps-md-3 border-start">
                                                <label class="form-label text-muted small fw-semibold">Historial de notes</label>
                                                <?php
                                                $historialA = !empty($alumne->observacions_alumne) ? json_decode($alumne->observacions_alumne, true) : [];
                                                ?>
                                                <?php if (!empty($historialA)): ?>
                                                    <div class="list-group list-group-flush border mt-1">
                                                        <?php foreach (array_reverse($historialA) as $obs): ?>
                                                            <div class="list-group-item py-2 bg-light">
                                                                <div class="d-flex justify-content-between">
                                                                    <small class="text-secondary small"><?= date('d/m/Y H:i', strtotime($obs['data'])) ?></small>
                                                                    <a href="<?= base_url('alumnes/eliminar-observacio-alumne/' . $alumne->id_alumne . '/' . $obs['id']) ?>" class="text-danger small text-decoration-none" onclick="return confirm('Eliminar?')">×</a>
                                                                </div>
                                                                <p class="mb-0 small"><?= esc($obs['text']) ?></p>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <p class="text-muted small">No hi ha notes en l'expedient.</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#documents">
                                    Documents adjunts
                                </button>
                            </h2>
                            <div id="documents" class="accordion-collapse collapse">
                                <div class="accordion-body">

                                    <form method="post"
                                        action="<?= base_url('alumnes/pujar-document/' . $alumne->id_alumne) ?>"
                                        enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label text-muted small">Tipus de document</label>
                                                <select name="tipus" class="form-select form-select-sm">
                                                    <option value="">Selecciona...</option>
                                                    <option value="DNI">DNI</option>
                                                    <option value="Certificat notes">Certificat de notes</option>
                                                    <option value="Justificant pagament">Justificant de pagament
                                                    </option>
                                                    <option value="Certificat bonificació">Certificat de bonificació
                                                    </option>
                                                    <option value="Altre">Altre</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label text-muted small">Fitxer</label>
                                                <input type="file" name="document" class="form-control form-control-sm"
                                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">Pujar
                                                    document</button>
                                            </div>
                                        </div>
                                    </form>

                                    <?php if (!empty($documents)): ?>
                                        <table class="table table-bordered table-hover table-sm mt-3">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tipus</th>
                                                    <th>Nom del fitxer</th>
                                                    <th>Any</th>
                                                    <th>Data pujada</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($documents as $doc): ?>
                                                    <tr>
                                                        <td><?= esc($doc->tipus ?? '—') ?></td>
                                                        <td><?= esc($doc->nom_original) ?></td>
                                                        <td><?= esc($doc->any_academic) ?></td>
                                                        <td><?= esc(date('d/m/Y H:i', strtotime($doc->creat_el))) ?></td>
                                                        <td class="text-end d-flex gap-1 justify-content-end">
                                                            <a href="<?= base_url('alumnes/document/' . $doc->id_document) ?>"
                                                                target="_blank" class="btn btn-outline-primary btn-sm">
                                                                Veure
                                                            </a>
                                                            <a href="<?= base_url('alumnes/eliminar-document/' . $doc->id_document) ?>"
                                                                class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Estàs segur que vols eliminar aquest document?')">
                                                                Eliminar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p class="text-muted mt-2">No hi ha documents adjunts.</p>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-start mt-4 mb-5 border-top pt-3">
                        <a href="<?= base_url('alumnes/pdf-expedient/' . $alumne->id_alumne) ?>" target="_blank"
                            class="btn btn-outline-danger btn-sm px-4">
                            Exportar a PDF
                        </a>
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
        const form = document.getElementById('formExpedient');
        const inputs = document.querySelectorAll('[form="formExpedient"]');

        btnEditar.addEventListener('click', function () {
            inputs.forEach(input => {
                input.disabled = false;
            });
            btnEditar.classList.add('d-none');
            btnGuardar.classList.remove('d-none');
            btnCancellar.classList.remove('d-none');
        });

        btnCancellar.addEventListener('click', function () {
            if (confirm('Estàs segur que vols cancel·lar els canvis?')) {
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