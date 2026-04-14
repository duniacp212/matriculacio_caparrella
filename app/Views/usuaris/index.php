<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 border-bottom-lila bg-white">
        <div class="row align-items-center">
            <div class="col-6">
                <h4 class="mb-0">Gestió d'Usuaris Administratius</h4>
            </div>
            <div class="col-6 text-end">
                <a href="<?= base_url('usuaris/nou') ?>" class="btn btn-primary btn-sm">Nou Usuari</a>
            </div>
        </div>
    </div>

    <div class="row flex-grow-1 g-0 mt-3">

        <?= view('layouts/aside') ?>

        <main class="col-10 pt-0 px-3 overflow-auto">

            <table class="table table-bordered table-hover bg-white mt-2">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom i Cognoms</th>
                        <th>DNI / NIE</th>
                        <th>Usuari</th>
                        <th>Rol</th>
                        <th>Accions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usuaris as $u): ?>

                        <tr>
                            <td><?= esc($u->id_usuari) ?></td>
                            <td><?= esc($u->nom) ?> <?= esc($u->cognom1) ?> <?= esc($u->cognom2) ?></td>
                            <td><?= esc($u->dni_nie) ?></td>
                            <td><?= esc($u->usuari) ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?= esc($u->rol) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('usuaris/editar/' . $u->id_usuari) ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                                <?php if ($u->rol !== 'super admin'): ?>
                                    <a href="<?= base_url('usuaris/eliminar/' . $u->id_usuari) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Estàs segur que vols eliminar aquest usuari?')">Eliminar</a>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>

            </table>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>