<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <main class="container-fluid p-4 overflow-auto">

        <div class="card shadow-sm">
            <div class="card-body">

                <form method="get" class="mb-3 d-flex align-items-end gap-3">

                    <div class="w-auto">
                        <label class="form-label mb-1">Any acadèmic</label>

                        <?php
                        $anyActual = date('Y');
                        $anyInici = 2000;
                        ?>

                        <select name="any" class="form-select">
                            <option value="">Tots</option>

                            <?php for ($i = $anyInici; $i <= $anyActual; $i++): ?>
                                <option value="<?= $i ?>"
                                    <?= ($anySeleccionat == $i) ? 'selected' : '' ?>>
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

                <h5 class="mb-3">Resum d'alumnes matriculats</h5>

                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40%">Tipus d'estudi</th>
                            <th style="width: 40%">Curs</th>
                            <th style="width: 20%" class="text-end">Alumnes matriculats</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $primer = true;
                        foreach ($dades as $estudi => $files):
                        ?>

                            <tr>
                                <td colspan="3" class="p-0 border-0">
                                    <details <?= $primer ? 'open' : '' ?>>
                                        <summary class="px-3 py-2 fw-semibold resum-lila">
                                            <?= esc($estudi) ?>
                                        </summary>

                                        <table class="table table-bordered table-hover mb-0">
                                            <tbody>
                                                <?php foreach ($files as $fila): ?>
                                                    <tr>
                                                        <td style="width: 40%"></td>
                                                        <td style="width: 40%"><?= esc($fila['curs']) ?></td>
                                                        <td style="width: 20%" class="text-end fw-semibold"><?= esc($fila['total']) ?></td>
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
                    <a href="<?= base_url('alumnes/exportar_resum_pdf') . '?any=' . esc($anySeleccionat) ?>" class="btn btn-outline-primary" target="_blank">
                        Exportar a PDF
                    </a>
                </div>

            </div>
        </div>

    </main>
</div>

<?= view('layouts/footer') ?>