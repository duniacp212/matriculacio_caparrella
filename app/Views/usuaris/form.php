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
                 <a href="<?= base_url('usuaris') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
            </div>

            <div class="card mt-2 shadow-sm border-0 mx-auto" style="max-width: 700px;">
                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= $url ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label fw-semibold">Nom</label>
                            <input type="text" name="nom" id="nom" value="<?= old('nom', $usuari->nom ?? '') ?>"
                                class="form-control form-control-sm" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cognom1" class="form-label fw-semibold">Primer Cognom</label>
                            <input type="text" name="cognom1" id="cognom1"
                                value="<?= old('cognom1', $usuari->cognom1 ?? '') ?>" class="form-control form-control-sm" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cognom2" class="form-label fw-semibold">Segon Cognom</label>
                            <input type="text" name="cognom2" id="cognom2"
                                value="<?= old('cognom2', $usuari->cognom2 ?? '') ?>" class="form-control form-control-sm">
                        </div>

                        <div class="mb-3">
                            <label for="dni_nie" class="form-label fw-semibold">DNI / NIE</label>
                            <input type="text" name="dni_nie" id="dni_nie"
                                value="<?= old('dni_nie', $usuari->dni_nie ?? '') ?>" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Correu electrònic</label>
                            <input type="email" name="email" id="email" value="<?= old('email', $usuari->email ?? '') ?>"
                                class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefon" class="form-label fw-semibold">Telèfon</label>
                            <input type="text" name="telefon" id="telefon" value="<?= old('telefon', $usuari->telefon ?? '') ?>"
                                class="form-control form-control-sm">
                        </div>

                        <div class="mb-3">
                            <label for="rol" class="form-label fw-semibold">Rol del sistema</label>
                            <select name="rol" id="rol" class="form-select form-select-sm">
                                <option value="secretaria" <?= (old('rol', $usuari->rol ?? '') == 'secretaria') ? 'selected' : '' ?>>Secretaria</option>
                                <option value="administracio" <?= (old('rol', $usuari->rol ?? '') == 'administracio') ? 'selected' : '' ?>>Administració</option>
                                <option value="super admin" <?= (old('rol', $usuari->rol ?? '') == 'super admin') ? 'selected' : '' ?>>Super Admin</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small">Contrasenya
                                <?= !empty($usuari->id_usuari) ? '(buida per no canviar)' : '' ?></label>
                            <input type="password" name="password" id="password" class="form-control form-control-sm"
                                <?= !empty($usuari->id_usuari) ? '' : 'required' ?>>
                        </div>

                        <div class="mb-4">
                            <label for="repetir_password" class="form-label fw-semibold small">Repeteix la contrasenya</label>
                            <input type="password" name="repetir_password" id="repetir_password"
                                class="form-control form-control-sm" <?= !empty($usuari->id_usuari) ? '' : 'required' ?>>
                        </div>

                        <div class="text-end border-top pt-3">
                            <a href="<?= base_url('usuaris') ?>" class="btn btn-outline-secondary btn-sm me-2 px-3">Cancel·lar</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4">Guardar Usuari</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>