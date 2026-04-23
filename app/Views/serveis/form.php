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

                    <form action="<?= esc($url) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipus</label>
                                <input type="text" name="tipus" value="<?= esc($servei['tipus'] ?? '') ?>" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Preu (€)</label>
                                <input type="number" name="preu" value="<?= esc($servei['preu'] ?? '') ?>" class="form-control" step="0.01" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Estat</label>
                                <select name="estat" class="form-select">
                                    <option value="actiu" <?= ($servei['estat'] ?? '') === 'actiu' ? 'selected' : '' ?>>Actiu</option>
                                    <option value="inactiu" <?= ($servei['estat'] ?? '') === 'inactiu' ? 'selected' : '' ?>>Inactiu</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end border-top pt-3">
                            <a href="<?= base_url('serveis') ?>" class="btn btn-outline-secondary btn-sm me-2">Cancel·lar</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4">Guardar</button>
                        </div>

                    </form>

                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>