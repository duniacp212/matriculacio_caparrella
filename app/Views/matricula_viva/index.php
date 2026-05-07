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

            <div class="d-flex justify-content-end gap-2 mb-3">
                <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4 me-auto">Tornar</a>
                
                <button type="button" id="btnSeleccionarTots" class="btn btn-outline-dark btn-sm px-4">
                    Seleccionar tots
                </button>

                <button type="button" id="btnAlternar" class="btn btn-outline-primary btn-sm px-4">
                    Activar / Desactivar seleccionats
                </button>

                <button type="submit" form="formMatriculaViva" name="accio" value="guardar" class="btn btn-success btn-sm px-4">
                    Guardar canvis
                </button>
            </div>

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

                <form id="formMatriculaViva" method="post" action="<?= base_url('matricula-viva/guardar') ?>">
                    <?= csrf_field() ?>

                    <div class="card-body p-0">

                        <?php
                        $blocs = [];

                        foreach ($estudis as $estudi) {
                            $tipusLlarg = trim($estudi['tipus']);
                            $bloc = '';

                            if (str_starts_with($tipusLlarg, 'CFGM')) { $bloc = 'FP Grau Mitjà'; } 
                            elseif (str_starts_with($tipusLlarg, 'CFGS')) { $bloc = 'FP Grau Superior'; } 
                            elseif (str_starts_with($tipusLlarg, 'Batxillerat')) { $bloc = 'Batxillerat'; } 
                            elseif (str_starts_with($tipusLlarg, 'ESO')) { $bloc = 'ESO'; } 
                            elseif (str_starts_with($tipusLlarg, 'FP Bàsica')) { $bloc = 'FP Bàsica'; } 
                            elseif (str_starts_with($tipusLlarg, 'PFI')) { $bloc = 'PFI'; } 
                            else { $bloc = 'Altres'; }

                            if (!isset($blocs[$bloc])) { $blocs[$bloc] = []; }
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
                                                        <input type="checkbox" name="estudis[]" value="<?= esc($estudi['id_estudi']) ?>" class="curso-check">
                                                        <input type="hidden" name="estat[<?= esc($estudi['id_estudi']) ?>]" value="<?= $estudi['matricula_viva'] ?>">
                                                    </td>
                                                    <td><?= esc($estudi['tipus']) ?> <?= esc($estudi['nivell']) ?></td>
                                                    <td>
                                                        <input type="number" name="places[<?= esc($estudi['id_estudi']) ?>]" value="<?= esc($estudi['places'] ?? '') ?>" class="form-control form-control-sm" min="0" placeholder="—">
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
                </form>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let canvisPendents = false;
    const botoSeleccionarTots = document.getElementById('btnSeleccionarTots');
    const botoAlternar = document.getElementById('btnAlternar');
    const botoGuardar = document.querySelector('button[value="guardar"]');
    const files = document.querySelectorAll('tbody tr');

    botoSeleccionarTots.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.curso-check');
        const totsMarcats = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(cb => cb.checked = !totsMarcats);
        this.textContent = totsMarcats ? 'Seleccionar tots' : 'Desmarcar tots';
    });

    const checks = document.querySelectorAll('.curso-check');
    checks.forEach(cb => {
        cb.addEventListener('change', function() {
            const totsMarcats = Array.from(checks).every(cb => cb.checked);
            botoSeleccionarTots.textContent = totsMarcats ? 'Desmarcar tots' : 'Seleccionar tots';
        });
    });

    botoAlternar.addEventListener('click', function() {
        const seleccionats = document.querySelectorAll('.curso-check:checked');
        
        if (seleccionats.length === 0) {
            alert('Si us plau, selecciona almenys un curs per activar o desactivar.');
            return;
        }

        seleccionats.forEach(checkbox => {
            const fila = checkbox.closest('tr');
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
        });

        botoSeleccionarTots.textContent = 'Seleccionar tots';
    });

    botoGuardar.addEventListener('click', function() {
        canvisPendents = false;
    });

    window.addEventListener('beforeunload', function (e) {
        if (canvisPendents) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

});
</script>

<?= view('layouts/footer') ?>