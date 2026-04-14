<?= view('layouts/header', ['title' => $title]) ?>

<div class="container-fluid vh-100 d-flex flex-column">
    <div class="d-flex align-items-center px-3 py-2 border-bottom bg-light">
        <a href="<?= base_url('/') ?>" class="me-3">
            <img src="<?= base_url('logo.png') ?>" alt="Logo" style="height: 70px" />
        </a>
        <div class="flex-grow-1 text-center fw-semibold fs-5"><?= esc($title) ?></div>
        <div>
            <span class="me-2 fw-semibold">Nom i Cognoms</span>
            <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-secondary">Sortir</a>
        </div>
    </div>

    <main class="container-fluid p-4 overflow-auto">
        <div class="container" style="max-width: 900px">
            <form method="post" action="<?= base_url('gestio/guardar-curs') ?>"
                <?= csrf_field() ?>
                class="bg-white p-4 shadow-sm rounded border">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nivell</label>
                        <input type="text" name="nivell" class="form-control" placeholder="1r, 2n..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tipus d'estudi</label>
                        <?php if ($tipusAuto === 'CFGS' || $tipusAuto === 'CFGM'): ?>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold"><?= $tipusAuto ?> -</span>
                                <input type="hidden" name="tipus_prefix" value="<?= $tipusAuto ?> - ">
                                <input type="text" name="tipus_nom" class="form-control" placeholder="Nom del cicle"
                                    required autofocus>
                            </div>
                        <?php else: ?>
                            <input type="text" name="tipus" class="form-control" value="<?= $tipusAuto ?>"
                                <?= !empty($tipusAuto) ? 'readonly' : '' ?> required>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Assignatures / Mòduls</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="afegirFila('llista-asig', 'assignatures[]')">+ Afegir</button>
                        </div>
                        <div id="llista-asig">
                            <input type="text" name="assignatures[]" class="form-control mb-2" placeholder="Nom">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Optatives</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="afegirFila('llista-opt', 'optatives[]')">+ Afegir</button>
                        </div>
                        <div id="llista-opt">
                            <input type="text" name="optatives[]" class="form-control mb-2" placeholder="Nom">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">Cancel·lar</a>
                    <button type="submit" class="btn btn-success px-4">Crear curs</button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function afegirFila(id, nom) {
        const div = document.getElementById(id);
        const row = document.createElement('div');
        row.className = 'input-group mb-2';

        row.innerHTML = `
        <input type="text" name="${nom}" class="form-control" placeholder="Nom...">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
            <i class="bi bi-trash"></i> Esborrar
        </button>
    `;

        div.appendChild(row);
    }
</script>

<?= view('layouts/footer') ?>