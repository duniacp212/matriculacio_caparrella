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

                    <div class="accordion mb-4 card-lila" id="accordionExpedient">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#dadesPersonals">
                                    Dades personals
                                </button>
                            </h2>
                            <div id="dadesPersonals" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="row g-0">
                                        <div class="col-md-6 pe-md-3">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Nom</label>
                                                <input class="form-control" value="<?= esc($alumne->nom) ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Primer cognom</label>
                                                <input class="form-control" value="<?= esc($alumne->cognom1) ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Segon cognom</label>
                                                <input class="form-control" value="<?= esc($alumne->cognom2 ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">DNI / NIE</label>
                                                <input class="form-control" value="<?= esc($alumne->dni) ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Data de naixement</label>
                                                <input class="form-control" value="<?= esc($alumne->data_naixement ? date('d/m/Y', strtotime($alumne->data_naixement)) : '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Lloc de naixement</label>
                                                <input class="form-control" value="<?= esc($alumne->lloc_naixement ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Nacionalitat</label>
                                                <input class="form-control" value="<?= esc($alumne->nacionalitat ?? '') ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ps-md-3 border-start">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Telèfon</label>
                                                <input class="form-control" value="<?= esc($alumne->telefon ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Telèfon 2</label>
                                                <input class="form-control" value="<?= esc($alumne->telefon2 ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Correu electrònic</label>
                                                <input class="form-control" value="<?= esc($alumne->email ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Carrer</label>
                                                <input class="form-control" value="<?= esc($alumne->carrer ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Número</label>
                                                <input class="form-control" value="<?= esc($alumne->numero ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Pis</label>
                                                <input class="form-control" value="<?= esc($alumne->pis ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Codi postal</label>
                                                <input class="form-control" value="<?= esc($alumne->codi_postal ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Població</label>
                                                <input class="form-control" value="<?= esc($alumne->poblacio ?? '') ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dadesAcademiques">
                                    Dades acadèmiques
                                </button>
                            </h2>
                            <div id="dadesAcademiques" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row g-0">
                                        <div class="col-md-6 pe-md-3">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Any acadèmic</label>
                                                <input class="form-control" value="<?= esc($alumne->any_matricula ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Estudi</label>
                                                <input class="form-control" value="<?= esc($alumne->tipus ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Curs</label>
                                                <input class="form-control" value="<?= esc($alumne->nivell ?? '') ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ps-md-3 border-start">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Torn</label>
                                                <input class="form-control" value="<?= !empty($alumne->torn) ? 'Torn ' . esc($alumne->torn) : '' ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Estat</label>
                                                <input class="form-control" value="<?= esc($alumne->estat ?? '') ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Bonificació</label>
                                                <input class="form-control" value="<?= esc($alumne->bonificats ?? '0') ?>%" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tutors">
                                    Tutors legals
                                </button>
                            </h2>
                            <div id="tutors" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <?php if (!empty($tutors)): ?>
                                        <?php foreach ($tutors as $tutor): ?>
                                            <div class="row g-0 mb-3 pb-3 border-bottom">
                                                <div class="col-md-6 pe-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Nom</label>
                                                        <input class="form-control" value="<?= esc($tutor->nom) ?> <?= esc($tutor->cognom1) ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">DNI</label>
                                                        <input class="form-control" value="<?= esc($tutor->dni) ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 ps-md-3 border-start">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Rol</label>
                                                        <input class="form-control" value="<?= esc($tutor['rol']) ?>" disabled>
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#observacions">
                                    Observacions
                                </button>
                            </h2>
                            <div id="observacions" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <textarea class="form-control" rows="4" disabled><?= esc($alumne->observacions ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#documents">
                                    Documents adjunts
                                </button>
                            </h2>
                            <div id="documents" class="accordion-collapse collapse">
                                <div class="accordion-body">

                                    <?php if (session()->getFlashdata('exit')): ?>
                                        <div class="alert alert-success py-2"><?= session()->getFlashdata('exit') ?></div>
                                    <?php endif; ?>

                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
                                    <?php endif; ?>

                                    <form method="post" action="<?= base_url('alumnes/pujar-document/' . $alumne->id_alumne) ?>" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label text-muted small">Tipus de document</label>
                                                <select name="tipus" class="form-select form-select-sm">
                                                    <option value="">Selecciona...</option>
                                                    <option value="DNI">DNI</option>
                                                    <option value="Certificat notes">Certificat de notes</option>
                                                    <option value="Justificant pagament">Justificant de pagament</option>
                                                    <option value="Certificat bonificació">Certificat de bonificació</option>
                                                    <option value="Altre">Altre</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label text-muted small">Fitxer</label>
                                                <input type="file" name="document" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">Pujar document</button>
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
                                                        <td><?= esc($doc['tipus'] ?? '—') ?></td>
                                                        <td><?= esc($doc['nom_original']) ?></td>
                                                        <td><?= esc($doc['any_academic']) ?></td>
                                                        <td><?= esc(date('d/m/Y H:i', strtotime($doc['creat_el']))) ?></td>
                                                        <td class="text-end">
                                                            <a href="<?= base_url('alumnes/eliminar-document/' . $doc['id_document']) ?>"
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

                    <div class="d-flex justify-content-between align-items-center mt-4 mb-5 border-top pt-3">
                        <button class="btn btn-outline-secondary btn-sm px-4">Exportar a PDF</button>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>