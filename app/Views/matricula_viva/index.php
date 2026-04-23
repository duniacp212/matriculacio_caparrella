<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid vh-100 d-flex flex-column">

    <main class="container-fluid p-4 overflow-auto">
        <div class="container" style="max-width: 1100px">

            <?php if (session()->getFlashdata('missatge')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('missatge') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm card-lila">
                <div class="card-header fw-semibold">
                    Cursos disponibles
                </div>

                <form method="post" action="<?= base_url('matricula-viva/guardar') ?>">
                    <?= csrf_field() ?>

                    <div class="card-body p-0">

                        <?php
                        $blocs = [];

                        foreach ($estudis as $estudi) {
                            $tipusLlarg = trim($estudi['tipus']);
                            $bloc = '';

                            if (str_starts_with($tipusLlarg, 'CFGM')) {
                                $bloc = 'FP Grau Mitjà';
                            } elseif (str_starts_with($tipusLlarg, 'CFGS')) {
                                $bloc = 'FP Grau Superior';
                            } elseif (str_starts_with($tipusLlarg, 'Batxillerat')) {
                                $bloc = 'Batxillerat';
                            } elseif (str_starts_with($tipusLlarg, 'ESO')) {
                                $bloc = 'ESO';
                            } elseif (str_starts_with($tipusLlarg, 'FP Bàsica')) {
                                $bloc = 'FP Bàsica';
                            } elseif (str_starts_with($tipusLlarg, 'PFI')) {
                                $bloc = 'PFI';
                            } else {
                                $bloc = 'Altres';
                            }

                            if (!isset($blocs[$bloc])) {
                                $blocs[$bloc] = [];
                            }

                            $blocs[$bloc][] = $estudi;
                        }

                        ksort($blocs);
                        ?>

                        <?php $primer = true; ?>

                        <?php foreach ($blocs as $titolBloc => $llistaEstudis): ?>
                            <?php if (!empty($llistaEstudis)): ?>

                                <details <?= $primer ? 'open' : '' ?>>
                                    <?php $primer = false; ?>
                                    <summary class="resum-lila"><?= esc($titolBloc) ?></summary>

                                    <table class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 50px"></th>
                                                <th>Curs</th>
                                                <th style="width: 150px">Places</th>
                                                <th class="text-end">Estat</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($llistaEstudis as $estudi): ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            name="estudis[]"
                                                            value="<?= esc($estudi['id_estudi']) ?>">

                                                        <input type="hidden"
                                                            name="estat[<?= esc($estudi['id_estudi']) ?>]"
                                                            value="<?= $estudi['matricula_viva'] ?>">
                                                    </td>

                                                    <td><?= esc($estudi['tipus']) ?> <?= esc($estudi['nivell']) ?></td>

                                                    <td>
                                                        <input type="number"
                                                            name="places[<?= esc($estudi['id_estudi']) ?>]"
                                                            value="<?= esc($estudi['places'] ?? '') ?>"
                                                            class="form-control form-control-sm"
                                                            min="0"
                                                            placeholder="—">
                                                    </td>

                                                    <td class="text-end <?= $estudi['matricula_viva'] ? 'text-success' : 'text-danger' ?>">
                                                        <?= $estudi['matricula_viva'] ? 'Activada' : 'Desactivada' ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>

                                </details>

                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>

                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/') ?>" id="btnTornar" class="btn btn-outline-secondary">
                            Tornar
                        </a>

                        <button type="button"
                            id="btnAlternar"
                            class="btn btn-outline-primary">
                            Activar / Desactivar
                        </button>

                        <button type="submit"
                            name="accio"
                            value="guardar"
                            class="btn btn-outline-primary">
                            Guardar canvis
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </main>

</div>

<script>
function alternarSeleccio() {
    const caselles = document.querySelectorAll('input[name="estudis[]"]');
    let hiHaDesmarcats = false;

    caselles.forEach(casella => {
        if (!casella.checked) {
            hiHaDesmarcats = true;
        }
    });

    caselles.forEach(casella => {
        casella.checked = hiHaDesmarcats;
    });
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    let canvisPendents = false;

    const botoAlternar = document.getElementById('btnAlternar');
    const botoGuardar = document.querySelector('button[value="guardar"]');
    const botoTornar = document.getElementById('btnTornar');

    const files = document.querySelectorAll('tbody tr');

    botoAlternar.addEventListener('click', function() {

        files.forEach(fila => {

            const checkbox = fila.querySelector('input[type="checkbox"]');

            if (checkbox && checkbox.checked) {

                const estatHidden = fila.querySelector('input[type="hidden"]');
                const celEstat = fila.querySelector('td:last-child');

                let estatActual = parseInt(estatHidden.value);
                let nouEstat = estatActual === 1 ? 0 : 1;

                estatHidden.value = nouEstat;

                if (nouEstat === 1) {
                    celEstat.textContent = 'Activada';
                    celEstat.classList.remove('text-danger');
                    celEstat.classList.add('text-success');
                } else {
                    celEstat.textContent = 'Desactivada';
                    celEstat.classList.remove('text-success');
                    celEstat.classList.add('text-danger');
                }

                checkbox.checked = false;
                canvisPendents = true;
            }

        });

    });

    botoGuardar.addEventListener('click', function() {
        canvisPendents = false;
    });

    botoTornar.addEventListener('click', function(e) {
        if (canvisPendents) {
            if (!confirm('Tens canvis sense guardar. Vols sortir igualment?')) {
                e.preventDefault();
            } else {
                canvisPendents = false;
            }
        }
    });

});
</script>

<?= view('layouts/footer') ?>