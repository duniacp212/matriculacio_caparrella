<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>
<?php $config_ui = model('App\Models\SettingsModel')->getSettings(); ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <form method="get" action="<?= current_url() ?>">
        <div class="px-3 pt-2 pb-1 bg-white">
            <div class="row align-items-end">

                <div class="col-12">
                    <div class="row g-2">

                        <?php if ($config_ui['filtre_any'] ?? true): ?>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Any</label>

                                <?php
                                $anyActual = date('Y');
                                $anyInici = 2000;
                                $anySeleccionat = $filtres['any'] ?? '';
                                ?>

                                <select name="any" class="form-select form-select-sm">
                                    <option value="">Tots</option>

                                    <?php for ($i = $anyInici; $i <= $anyActual; $i++): ?>
                                        <option value="<?= $i ?>" <?= $anySeleccionat == $i ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>

                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($config_ui['filtre_estudi'] ?? true): ?>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Estudi</label>
                                <select name="estudi" class="form-select form-select-sm">

                                    <option value="">Tots</option>

                                    <?php foreach ($estudis as $e): ?>
                                        <option value="<?= esc($e['tipus']) ?>" <?= ($filtres['estudi'] ?? '') === $e['tipus'] ? 'selected' : '' ?>>
                                            <?= esc($e['tipus']) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($config_ui['filtre_curs'] ?? true): ?>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Curs</label>
                                <select name="curs" class="form-select form-select-sm">

                                    <option value="">Tots</option>

                                    <?php foreach ($cursos as $c): ?>
                                        <option value="<?= esc($c['nivell']) ?>" <?= ($filtres['curs'] ?? '') == $c['nivell'] ? 'selected' : '' ?>>
                                            <?= esc($c['nivell']) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($config_ui['filtre_torn'] ?? true): ?>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Torn</label>
                                <select name="torn" class="form-select form-select-sm">

                                    <option value="">Tots</option>
                                    <option value="1" <?= ($filtres['torn'] ?? '') == 1 ? 'selected' : '' ?>>Torn 1</option>
                                    <option value="2" <?= ($filtres['torn'] ?? '') == 2 ? 'selected' : '' ?>>Torn 2</option>
                                    <option value="3" <?= ($filtres['torn'] ?? '') == 3 ? 'selected' : '' ?>>Torn 3</option>

                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($config_ui['filtre_estat'] ?? true): ?>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Estat</label>
                                <select name="estat" class="form-select form-select-sm">
                                    <option value="">Tots</option>
                                    <option value="Validat" <?= ($filtres['estat'] ?? '') === 'Validat' ? 'selected' : '' ?>>
                                        Validat</option>
                                    <option value="Pendent" <?= ($filtres['estat'] ?? '') === 'Pendent' ? 'selected' : '' ?>>
                                        Pendent</option>
                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($config_ui['filtre_pagament'] ?? true): ?>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Pagament</label>
                                <select name="pagament" class="form-select form-select-sm">
                                    <option value="">Tots</option>
                                    <option value="pagat" <?= ($filtres['pagament'] ?? '') === 'pagat' ? 'selected' : '' ?>>
                                        Pagat</option>
                                    <option value="pendent" <?= ($filtres['pagament'] ?? '') === 'pendent' ? 'selected' : '' ?>>No pagat</option>
                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($config_ui['filtre_bonificacio'] ?? true): ?>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Bonificació</label>
                                <select name="bonificacio" class="form-select form-select-sm">
                                    <option value="">Totes</option>
                                    <option value="0" <?= ($filtres['bonificats'] ?? '') === '0' ? 'selected' : '' ?>>Sense
                                        bonificació (0%)</option>
                                    <option value="50" <?= ($filtres['bonificats'] ?? '') === '50' ? 'selected' : '' ?>>50%
                                    </option>
                                    <option value="100" <?= ($filtres['bonificats'] ?? '') === '100' ? 'selected' : '' ?>>100%
                                    </option>
                                </select>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="col-12 mt-2 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Filtrar</button>
                    <a href="<?= current_url() ?>" class="btn btn-outline-secondary btn-sm">Netejar Filtres</a>
                    <button type="button" id="btnVeureExpedient" class="btn btn-outline-primary btn-sm">Veure
                        expedient</button>
                    <button type="button" id="btnVeureMatricula" class="btn btn-outline-primary btn-sm">Veure
                        matrícula</button>
                    <button type="button" id="btnContactar" class="btn btn-outline-secondary btn-sm">Contactar</button>
                </div>

            </div>
        </div>
    </form>

    <div class="row flex-grow-1 g-0 mt-1">

        <?= view('layouts/aside') ?>

        <main class="col-10 pt-0 px-3 overflow-auto">

            <table class="table table-bordered table-hover table-sm bg-white">

                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Cognoms</th>
                        <th>DNI</th>
                        <th>Estudi</th>
                        <th>Curs</th>
                        <th>Torn</th>
                        <th>Estat</th>
                        <th>Pagament</th>
                        <th>Bonificació</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($alumnes as $alumne): ?>

                        <tr>

                            <td>
                                <input type="radio" name="matricula_id" value="<?= esc($alumne->id_matricula) ?>"
                                    data-alumne-id="<?= esc($alumne->id_alumne) ?>">
                            </td>
                            <td><?= esc($alumne->nom) ?></td>
                            <td><?= esc($alumne->cognom1) ?> <?= esc($alumne->cognom2) ?></td>
                            <td><?= esc($alumne->dni) ?></td>
                            <td><?= esc($alumne->estudi ?? '') ?></td>
                            <td><?= esc($alumne->curs ?? '') ?></td>
                            <td><?= !empty($alumne->torn) ? 'Torn ' . esc($alumne->torn) : '' ?></td>

                            <td><?= esc($alumne->estat) ?></td>

                            <td class="<?= !empty($alumne->data_pagament) ? 'text-success' : 'text-danger' ?>">
                                <?= !empty($alumne->data_pagament) ? 'Pagat' : 'No pagat' ?>
                            </td>
                            <td>
                                <?php if ($alumne->bonificats == 50): ?>
                                    <span class="badge bg-warning text-dark">50%</span>
                                <?php elseif ($alumne->bonificats == 100): ?>
                                    <span class="badge bg-success">100%</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">0%</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Total: <?= $total ?> alumnes
                </div>
                <div class="d-flex justify-content-center flex-grow-1">
                    <?= $paginador->links('default', 'bootstrap_full') ?>
                </div>
                <div style="width: 120px"></div>
            </div>

        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function seleccionat() {
            return document.querySelector('input[name="matricula_id"]:checked');
        }

        document.getElementById('btnVeureExpedient').onclick = function () {
            const s = seleccionat();
            if (!s) return alert('Selecciona una matrícula primer');
            window.location.href = "<?= base_url('alumnes/expedient') ?>/" + s.dataset.alumneId;
        };

        document.getElementById('btnVeureMatricula').onclick = function () {
            const s = seleccionat();
            if (!s) return alert('Selecciona una matrícula primer');
            window.location.href = "<?= base_url('matricules/matricula_alumne') ?>/" + s.value;
        };

        document.getElementById('btnContactar').onclick = function () {
            const s = seleccionat();
            if (!s) return alert('Selecciona una matrícula primer');
            window.location.href = "<?= base_url('alumnes/contacte') ?>/" + s.dataset.alumneId;
        };

    });
</script>

<?= view('layouts/footer') ?>