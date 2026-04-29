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
                 <a href="<?= base_url('bonificacions/nou') ?>" class="btn btn-primary btn-sm px-4 ms-auto">Nova bonificació</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <?php if (session()->getFlashdata('exit')): ?>
                        <div class="alert alert-success py-2 small"><?= session()->getFlashdata('exit') ?></div>
                    <?php endif; ?>

                    <?php if (empty($bonificacions)): ?>
                        <div class="alert alert-info">No hi ha bonificacions definides.</div>
                    <?php else: ?>

                        <form method="post" action="<?= base_url('bonificacions/guardar') ?>">
                            <?= csrf_field() ?>

                            <table class="table table-bordered table-hover bg-white mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipus de bonificació</th>
                                        <th>Descripció</th>
                                        <th style="width: 150px">Percentatge (%)</th>
                                        <th style="width: 100px" class="text-end">Accions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bonificacions as $boni): ?>
                                        <tr>
                                            <td class="fw-semibold"><?= esc($boni['tipus']) ?></td>
                                            <td>
                                                <input type="text"
                                                    name="descripcio[<?= $boni['id_bonificacio'] ?>]"
                                                    value="<?= esc($boni['descripcio'] ?? '') ?>"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="number"
                                                    name="percentatge[<?= $boni['id_bonificacio'] ?>]"
                                                    value="<?= esc($boni['percentatge'] ?? '') ?>"
                                                    class="form-control form-control-sm"
                                                    step="0.01"
                                                    min="0"
                                                    max="100">
                                            </td>
                                            <td class="text-end">
                                                <a href="<?= base_url('bonificacions/eliminar/' . $boni['id_bonificacio']) ?>"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Estàs segur que vols eliminar aquesta bonificació?')">
                                                    Eliminar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="text-end border-top pt-3 mt-3">
                                <button type="submit" class="btn btn-success btn-sm px-4">Guardar canvis</button>
                            </div>

                        </form>

                    <?php endif; ?>

                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>
