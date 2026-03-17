<?= view('layouts/header', ['title' => $title]) ?>

<div class="container-fluid vh-100 d-flex flex-column">

    <div class="d-flex align-items-center px-3 py-2 border-bottom bg-light">
        <a href="<?= base_url('/') ?>" class="me-3">
            <img src="<?= base_url('logo.png') ?>" alt="Logo" style="height: 70px" />
        </a>

        <div class="flex-grow-1 text-center fw-semibold fs-5">
            <?= esc($title) ?>
        </div>

        <div>
            <span class="me-2 fw-semibold">Nom i Cognoms</span>
            <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-secondary">Sortir</a>
        </div>
    </div>

    <main class="container-fluid p-4 overflow-auto">
        <div class="container" style="max-width: 1100px">

            <div class="d-flex justify-content-end gap-2 mb-3">
                <button class="btn btn-outline-secondary">Duplicar</button>
                <button class="btn btn-outline-danger">Eliminar</button>
                <button class="btn btn-outline-primary">Editar</button>
                <a href="#" class="btn btn-outline-primary">Afegir curs</a>
                <a href="#" class="btn btn-success">Afegir assignatura</a>
            </div>

            <form method="post" action="">

                <?php if (empty($cursos)): ?>
                    <div class="alert alert-info">
                        No hi ha cursos disponibles d'aquesta categoria.
                    </div>
                <?php else: ?>
                    <?php $primer = true; ?>
                    <?php foreach ($cursos as $curs): ?>
                        <div class="card mb-4 shadow-sm card-lila">
                            <details <?= $primer ? 'open' : '' ?>>
                                <?php $primer = false; ?>
                                <summary class="resum-lila">
                                    <input type="checkbox" name="cursos[]" value="<?= esc($curs['id_estudi']) ?>" />
                                    <?= esc($curs['nivell']) ?> <?= esc($curs['tipus']) ?>
                                </summary>

                                <div class="card-body">
                                    <h6 class="text-secondary fw-semibold mb-3">Assignatures / Mòduls</h6>
                                    <div class="row g-2 mb-4">
                                        <?php if (empty($curs['assignatures'])): ?>
                                            <div class="col-12 text-muted">
                                                No s'han trobat assignatures.
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($curs['assignatures'] as $assignatura): ?>
                                                <div class="col-md-4">
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="assignatures[]" value="<?= esc($assignatura['id_assignatura']) ?>" />
                                                        <?= esc($assignatura['nom']) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>

                                    <h6 class="text-secondary fw-semibold mb-3">Assignatures Optatives</h6>
                                    <div class="row g-2">
                                        <?php if (empty($curs['optatives'])): ?>
                                            <div class="col-12 text-muted">
                                                No s'han trobat optatives.
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($curs['optatives'] as $optativa): ?>
                                                <div class="col-md-4">
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="optatives[]" value="<?= esc($optativa['id_optativa']) ?>" />
                                                        <?= esc($optativa['nom']) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </details>
                        </div>
                    <?php endforeach; ?>

                <?php endif; ?>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">Cancel·lar</a>
                    <button type="submit" class="btn btn-success">Guardar canvis</button>
                </div>

            </form>

        </div>
    </main>

</div>

<?= view('layouts/footer') ?>
