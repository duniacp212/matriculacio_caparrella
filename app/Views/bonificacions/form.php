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
                 <a href="<?= base_url('bonificacions') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
            </div>

            <div class="card shadow-sm border-0 mx-auto" style="max-width: 800px;">
                <div class="card-body p-4">

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= esc($url) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row align-items-end">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Tipus de bonificació</label>
                                <input type="text" name="tipus" value="<?= esc($bonificacio['tipus'] ?? '') ?>" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label fw-semibold">Descripció</label>
                                <input type="text" name="descripcio" value="<?= esc($bonificacio['descripcio'] ?? '') ?>" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold text-nowrap">Percentatge (%)</label>
                                <input type="number" name="percentatge" value="<?= esc($bonificacio['percentatge'] ?? '') ?>" class="form-control form-control-sm" step="0.01" min="0" max="100" required>
                            </div>
                        </div>

                        <div class="text-end border-top pt-3 mt-3">
                            <a href="<?= base_url('bonificacions') ?>" class="btn btn-outline-secondary btn-sm me-2 px-3">Cancel·lar</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4">Guardar</button>
                        </div>

                    </form>

                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>
