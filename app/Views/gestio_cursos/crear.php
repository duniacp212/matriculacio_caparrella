<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 bg-white">
        <div class="row align-items-center">
            <div class="col-12 d-flex align-items-center gap-3">
                 <a href="<?= base_url('gestio/eso') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
                 <h4 class="mb-0"><?= esc($title) ?></h4>
            </div>
        </div>
    </div>

    <div class="row flex-grow-1 g-0 mt-3">

        <main class="col-12 pt-0 px-3 overflow-auto">
            <div class="container" style="max-width: 900px">
                <form method="post" action="<?= $url ?? base_url('gestio/guardar-curs') ?>" class="bg-white p-4 shadow-sm rounded border mt-4">
                    <?= csrf_field() ?>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nivell</label>
                            <input type="text" name="nivell" class="form-control" placeholder="1r, 2n..." value="<?= old('nivell', $curs['nivell'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipus d'estudi</label>
                            <?php if ($tipusAuto === 'CFGS' || $tipusAuto === 'CFGM' || $tipusAuto === 'BATXILLERAT'): ?>
                                <?php 
                                    $prefixLabel = $tipusAuto;
                                    if ($tipusAuto === 'BATXILLERAT') $prefixLabel = 'Batxillerat';
                                ?>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold"><?= $prefixLabel ?> -</span>
                                    <input type="hidden" name="tipus_prefix" value="<?= $prefixLabel ?> - ">
                                    <input type="text" name="tipus_nom" class="form-control" 
                                        placeholder="<?= $tipusAuto === 'BATXILLERAT' ? 'Modalitat' : 'Nom del cicle' ?>"
                                        value="<?= old('tipus_nom', $tipusNom ?? '') ?>"
                                        required autofocus>
                                </div>
                            <?php else: ?>
                                <input type="text" name="tipus" class="form-control" value="<?= old('tipus', $curs['tipus'] ?? $tipusAuto) ?>"
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
                                <?php if (!empty($assignatures)): ?>
                                    <?php foreach ($assignatures as $a): ?>
                                        <div class="input-group mb-2">
                                            <input type="text" name="assignatures[]" class="form-control" value="<?= esc($a['nom']) ?>">
                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                Esborrar
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <input type="text" name="assignatures[]" class="form-control mb-2" placeholder="Nom">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Optatives</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="afegirFila('llista-opt', 'optatives[]')">+ Afegir</button>
                            </div>
                            <div id="llista-opt">
                                <?php if (!empty($optatives)): ?>
                                    <?php foreach ($optatives as $o): ?>
                                        <div class="input-group mb-2">
                                            <input type="text" name="optatives[]" class="form-control" value="<?= esc($o['nom']) ?>">
                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                Esborrar
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <input type="text" name="optatives[]" class="form-control mb-2" placeholder="Nom">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">Cancel·lar</a>
                        <button type="submit" class="btn btn-success px-4"><?= isset($curs) ? 'Actualitzar' : 'Crear' ?> curs</button>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script>
    function afegirFila(id, nom) {
        const div = document.getElementById(id);
        const row = document.createElement('div');
        row.className = 'input-group mb-2';

        row.innerHTML = `
        <input type="text" name="${nom}" class="form-control" placeholder="Nom...">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
            Esborrar
        </button>
    `;

        div.appendChild(row);
    }
</script>

<?= view('layouts/footer') ?>