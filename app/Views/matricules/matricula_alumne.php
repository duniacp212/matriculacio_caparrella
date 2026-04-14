<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="row flex-grow-1 g-0 mt-3">

        <?= view('layouts/aside') ?>

        <main class="col-10 pt-3 px-4">

            <div class="card shadow-sm">

                <div class="card-header bg-white" style="border-bottom: 1px solid #dee2e6;">
                    <h5 class="mb-0">Dades de la matrícula</h5>
                </div>

                <div class="card-body">

                    <div class="row mb-4">

                        <div class="col-md-4">
                            <label class="form-label text-muted">Nom</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['nom']) ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted">Cognoms</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['cognom1']) ?> <?= esc($matricula['cognom2']) ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted">DNI</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['dni']) ?>
                            </div>
                        </div>

                    </div>


                    <div class="row mb-4">

                        <div class="col-md-4">
                            <label class="form-label text-muted">Estudi</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['tipus']) ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label text-muted">Curs</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['nivell']) ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label text-muted">Torn</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['torn']) ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label text-muted">Estat</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['estat']) ?>
                            </div>
                        </div>

                    </div>


                    <div class="row mb-4">

                        <div class="col-md-3">
                            <label class="form-label text-muted">Data matrícula</label>
                            <div class="fw-semibold">
                                <?= esc($matricula['data']) ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-muted">Data pagament</label>
                            <div class="fw-semibold">

                                <?php if (!empty($matricula['data_pagament'])): ?>
                                    <span class="text-success"><?= esc($matricula['data_pagament']) ?></span>
                                <?php else: ?>
                                    <span class="text-danger">No pagat</span>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-12">
                            <label class="form-label text-muted">Observacions</label>

                            <div class="border rounded p-3 bg-light">

                                <?php if (!empty($matricula['bonificacio_nom'])): ?>
                                    <div>
                                        <strong>Bonificació:</strong> <?= esc($matricula['bonificacio_nom']) ?> (<?= esc($matricula['bonificacio_percentatge']) ?>%)
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($matricula['observacions'])): ?>
                                    <div class="mt-2">
                                        <?= esc($matricula['observacions']) ?>
                                    </div>
                                <?php elseif (empty($matricula['bonificacio_nom'])): ?>
                                    <span class="text-muted">Sense observacions</span>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>

                </div>


                <div class="card-footer bg-white d-flex justify-content-end gap-2">

                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-sm">
                        Tornar
                    </a>

                    <a href="<?= base_url('matricules/editar/' . $matricula['id_matricula']) ?>" class="btn btn-outline-primary btn-sm">
                        Editar matrícula
                    </a>

                </div>

            </div>

        </main>

    </div>

</div>

<?= view('layouts/footer') ?>