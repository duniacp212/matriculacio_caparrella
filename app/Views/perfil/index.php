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

            <div class="card mt-2 shadow-sm border-0 mx-auto" style="max-width: 700px;">
                <div class="card-body p-4">

                    <?php if (session()->getFlashdata('exit')): ?>
                        <div class="alert alert-success py-2"><?= session()->getFlashdata('exit') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger py-2">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <h5 class="pb-2">Dades personals</h5>
                        <div class="mb-3">
                            <label class="text-muted small d-block">Nom i cognoms</label>
                            <div class="fw-semibold"><?= esc($usuari->nom) ?> <?= esc($usuari->cognom1) ?>
                                <?= esc($usuari->cognom2) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small d-block">DNI / NIE</label>
                            <div class="fw-semibold"><?= esc($usuari->dni_nie) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small d-block">Nom d'usuari</label>
                            <div class="fw-semibold"><?= esc($usuari->usuari) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small d-block">Rol assignat</label>
                            <div><span class="badge bg-info text-dark"><?= esc($usuari->rol) ?></span></div>
                        </div>
                    </div>

                    <h5 class="pb-2 mt-4">Canviar contrasenya</h5>
                    <form action="<?= base_url('perfil/actualitzar') ?>" method="post">

                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nova contrasenya <span class="text-muted small">(buida
                                    per no canviar)</span></label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Repeteix la contrasenya</label>
                            <input type="password" name="repetir_password" class="form-control">
                        </div>

                        <div class="text-end border-top pt-3">
                            <button type="submit" class="btn btn-primary btn-sm px-4">Guardar canvis</button>
                        </div>

                    </form>

                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>