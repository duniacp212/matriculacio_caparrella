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

            <div class="container" style="max-width: 900px">
                <form action="<?= base_url('alumnes/enviar_correu/' . $alumne->id_alumne) ?>" method="post" class="card shadow-sm card-lila p-0 mt-2">
                    <?= csrf_field() ?>

                    <div class="card-header fw-semibold">Dades de l’alumne</div>

                    <?php if (session()->getFlashdata('exit')): ?>
                        <div class="alert alert-success m-3 py-2 small">
                        <?= session()->getFlashdata('exit') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger m-3 py-2 small">
                        <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Nom i cognoms</label>
                            <div class="form-control-plaintext fw-semibold">
                                <?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?> <?= esc($alumne->cognom2) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">DNI / NIE</label>
                            <div class="form-control-plaintext fw-semibold">
                                <?= esc($alumne->dni) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Estudi / Curs</label>
                            <div class="form-control-plaintext fw-semibold">
                                <?= esc($alumne->tipus) ?> <?= esc($alumne->nivell) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Correu electrònic</label>
                            <div class="form-control-plaintext fw-semibold">
                                <?= esc($alumne->email) ?>
                            </div>
                        </div>

                        </div>
                    </div>

                    <div class="card-header fw-semibold border-top">Missatge</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Motiu del contacte</label>
                            <select name="motiu" class="form-select form-select-sm">
                                <option>Informació general</option>
                                <option>Matrícula</option>
                                <option>Pagament</option>
                                <option>Expedient</option>
                                <option>Baixa</option>
                                <option>Altres</option>
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold">Missatge</label>
                            <textarea name="missatge" class="form-control" rows="5"
                            placeholder="Escriu aquí el missatge que vols enviar a l'alumne..."></textarea>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end gap-2 p-3">
                        <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4">
                            Cancel·lar
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            Enviar missatge
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>

<?= view('layouts/footer') ?>