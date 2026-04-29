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
                 <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4 me-4">Tornar</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form method="get" class="mb-3 d-flex align-items-end gap-3">

                        <div class="w-auto">
                            <label class="form-label mb-1 small text-muted">Any acadèmic</label>

                            <?php
                            $anyActual = date('Y');
                            $anyInici = 2000;
                            ?>

                            <select name="any" class="form-select form-select-sm">
                                <option value="">Tots els anys</option>

                                <?php for ($i = $anyInici; $i <= $anyActual; $i++): ?>
                                    <option value="<?= $i ?>"
                                        <?= ($anySeleccionat == $i) ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>

                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-outline-primary btn-sm px-4">
                                Filtrar
                            </button>
                        </div>

                        <div class="ms-auto text-end">
                            <a href="<?= base_url('alumnes/exportar_resum_pdf') . '?any=' . esc($anySeleccionat) ?>" class="btn btn-success btn-sm px-4" target="_blank">
                                Exportar a PDF
                            </a>
                        </div>

                    </form>

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

                    <div class="text-end fw-bold fs-5 mt-4 p-3 bg-light rounded">
                        Total alumnes matriculats: <?= esc($totalGeneral) ?>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>