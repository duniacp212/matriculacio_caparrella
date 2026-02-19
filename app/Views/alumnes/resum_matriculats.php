<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <main class="container-fluid p-4 overflow-auto">

        <div class="card shadow-sm">
            <div class="card-body">

                <form method="get" class="mb-3 d-flex align-items-end gap-3">

                    <div>
                        <label class="form-label mb-1">Any acadèmic</label>
                        <select name="any" class="form-select">
                            <option value="">Tots</option>

                            <?php for ($i = 2017; $i <= 2030; $i++): ?>
                                <option value="<?= $i ?>" <?= ($anyActual == $i) ? 'selected' : '' ?>>
                                    <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-outline-primary">
                            Filtrar
                        </button>
                    </div>

                </form>


                <h5 class="mb-3">Resum d’alumnes matriculats</h5>

                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tipus d’estudi</th>
                            <th>Cicle</th>
                            <th>Curs</th>
                            <th class="text-end">Alumnes matriculats</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $primer = true;
                        foreach ($dades as $estudi => $files):
                        ?>

                            <tr>
                                <td colspan="4" class="p-0 border-0">
                                    <details <?= $primer ? 'open' : '' ?>>
                                        <summary class="px-3 py-2 fw-semibold resum-lila">
                                            <?= esc($estudi) ?>
                                        </summary>

                                        <table class="table table-bordered table-hover mb-0">
                                            <tbody>

                                                <?php foreach ($files as $fila): ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= esc($fila['cicle'] ?? '—') ?></td>
                                                        <td><?= esc($fila['curs']) ?></td>
                                                        <td class="text-end fw-semibold">
                                                            <?= esc($fila['total']) ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>

                                    </details>
                                </td>
                            </tr>

                        <?php
                            $primer = false;
                        endforeach;
                        ?>

                    </tbody>
                </table>

                <div class="text-end fw-bold fs-5 mt-3">
                    Total alumnes matriculats: <?= esc($totalGeneral) ?>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary">
                        Tornar
                    </a>
                    <button class="btn btn-outline-primary">
                        Exportar a PDF
                    </button>
                </div>

            </div>
        </div>

    </main>
</div>

<?= view('layouts/footer') ?>