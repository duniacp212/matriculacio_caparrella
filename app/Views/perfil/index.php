<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 border-bottom-lila bg-white">
        <div class="row align-items-center">
            <div class="col-12">
                <h4 class="mb-0"><?= esc($title) ?></h4>
            </div>
        </div>
    </div>

    <div class="row flex-grow-1 g-0 mt-3">

        <?= view('layouts/aside') ?>

        <main class="col-10 pt-0 px-3 overflow-auto">

            <div class="card mt-2 shadow-sm border-0">
                <div class="card-body">

                    <?php if (session()->getFlashdata('exit')): ?>
                        <div class="alert alert-success py-2"><?= session()->getFlashdata('exit') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label text-muted">Nom</label>
                            <div class="fw-semibold"><?= esc($usuari->nom) ?> <?= esc($usuari->cognom1) ?> <?= esc($usuari->cognom2) ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">DNI / NIE</label>
                            <div class="fw-semibold"><?= esc($usuari->dni_nie) ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Rol</label>
                            <div><span class="badge bg-info text-dark"><?= esc($usuari->rol) ?></span></div>
                        </div>
                    </div>

                    <form action="<?= base_url('perfil/actualitzar') ?>" method="post">

                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom d'usuari</label>
                                <input type="text" name="usuari" value="<?= esc($usuari->usuari) ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nova contrasenya <span class="text-muted">(buida per no canviar)</span></label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Repeteix la contrasenya</label>
                                <input type="password" name="repetir_password" class="form-control">
                            </div>
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