<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 border-bottom-lila bg-white">
        <div class="row align-items-center">
            <div class="col-6">
                <h4 class="mb-0"><?= esc($title) ?></h4>
            </div>
            <div class="col-6 text-end">
                <a href="<?= base_url('serveis/nou') ?>" class="btn btn-primary btn-sm">Nou servei</a>
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

                    <?php if (empty($serveis)): ?>
                        <div class="alert alert-info">No hi ha serveis complementaris definits.</div>
                    <?php else: ?>

                        <form method="post" action="<?= base_url('serveis/guardar') ?>">
                            <?= csrf_field() ?>

                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipus</th>
                                        <th style="width: 150px">Preu (€)</th>
                                        <th style="width: 150px">Estat</th>
                                        <th style="width: 100px">Accions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($serveis as $servei): ?>
                                        <tr>
                                            <td><?= esc($servei['tipus']) ?></td>
                                            <td>
                                                <input type="number"
                                                    name="preu[<?= $servei['id_servei'] ?>]"
                                                    value="<?= esc($servei['preu'] ?? '') ?>"
                                                    class="form-control form-control-sm"
                                                    step="0.01"
                                                    min="0">
                                            </td>
                                            <td>
                                                <select name="estat[<?= $servei['id_servei'] ?>]" class="form-select form-select-sm">
                                                    <option value="actiu" <?= $servei['estat'] === 'actiu' ? 'selected' : '' ?>>Actiu</option>
                                                    <option value="inactiu" <?= $servei['estat'] === 'inactiu' ? 'selected' : '' ?>>Inactiu</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('serveis/eliminar/' . $servei['id_servei']) ?>"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Estàs segur que vols eliminar aquest servei?')">
                                                    Eliminar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="text-end border-top pt-3">
                                <button type="submit" class="btn btn-primary btn-sm px-4">Guardar canvis</button>
                            </div>

                        </form>

                    <?php endif; ?>

                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>