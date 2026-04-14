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

                    <form action="<?= $url ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" name="nom" id="nom" value="<?= esc($usuari->nom ?? '') ?>"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cognom1" class="form-label">Primer Cognom</label>
                                <input type="text" name="cognom1" id="cognom1"
                                    value="<?= esc($usuari->cognom1 ?? '') ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cognom2" class="form-label">Segon Cognom</label>
                                <input type="text" name="cognom2" id="cognom2"
                                    value="<?= esc($usuari->cognom2 ?? '') ?>" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dni_nie" class="form-label">DNI / NIE</label>
                                <input type="text" name="dni_nie" id="dni_nie"
                                    value="<?= esc($usuari->dni_nie ?? '') ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="usuari" class="form-label">Nom d'usuari (login)</label>
                                <input type="text" name="usuari" id="usuari" value="<?= esc($usuari->usuari ?? '') ?>"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contrasenya
                                    <?= !empty($usuari->id_usuari) ? '(buida per no canviar)' : '' ?></label>
                                <input type="password" name="password" id="password" class="form-control"
                                    <?= !empty($usuari->id_usuari) ? '' : 'required' ?>>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="repetir_password" class="form-label">Repeteix la contrasenya</label>
                                <input type="password" name="repetir_password" id="repetir_password"
                                    class="form-control" <?= !empty($usuari->id_usuari) ? '' : 'required' ?>>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol del sistema</label>
                            <select name="rol" id="rol" class="form-select">
                                <option value="secretaria" <?= (isset($usuari) && $usuari->rol == 'secretaria') ? 'selected' : '' ?>>Secretaria</option>
                                <option value="administracio" <?= (isset($usuari) && $usuari->rol == 'administracio') ? 'selected' : '' ?>>Administració</option>
                                <option value="super admin" <?= (isset($usuari) && $usuari->rol == 'super admin') ? 'selected' : '' ?>>Super Admin</option>
                            </select>
                        </div>

                        <div class="text-end border-top pt-3">
                            <a href="<?= base_url('usuaris') ?>"
                                class="btn btn-outline-secondary btn-sm me-2 px-3">Tornar</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4">Guardar Usuari</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>