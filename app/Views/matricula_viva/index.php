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

                    <div class="card-body p-0">

                        <?php
                        $blocs = [
                            'ESO' => [],
                            'Batxillerat' => [],
                            'FP Grau Mitjà' => [],
                            'FP Grau Superior' => [],
                            'FP Bàsica' => [],
                            'PFI' => []
                        ];

                        foreach ($estudis as $estudi) {

                            $nomEstudi = $estudi['nom'];

                            if (str_contains($nomEstudi, 'ESO')) {
                                $blocs['ESO'][] = $estudi;
                            } elseif (str_contains($nomEstudi, 'Batxillerat')) {
                                $blocs['Batxillerat'][] = $estudi;
                            } elseif (str_contains($nomEstudi, 'SMX') || str_contains($nomEstudi, 'Electromec')) {
                                $blocs['FP Grau Mitjà'][] = $estudi;
                            } elseif (str_contains($nomEstudi, 'DAW') || str_contains($nomEstudi, 'DAM')) {
                                $blocs['FP Grau Superior'][] = $estudi;
                            } elseif (str_contains($nomEstudi, 'FP B')) {
                                $blocs['FP Bàsica'][] = $estudi;
                            } elseif (str_contains($nomEstudi, 'PFI')) {
                                $blocs['PFI'][] = $estudi;
                            }
                        }
                        ?>

                        <?php foreach ($blocs as $titolBloc => $llistaEstudis): ?>
                            <?php if (!empty($llistaEstudis)): ?>

                                <details open>
                                    <summary class="resum-lila"><?= esc($titolBloc) ?></summary>

                                    <table class="table mb-0">
                                        <tbody>

                                            <?php foreach ($llistaEstudis as $estudi): ?>
                                                <tr>
                                                    <td style="width: 50px">
                                                        <input type="checkbox"
                                                            name="estudis[]"
                                                            value="<?= esc($estudi['id_estudi']) ?>">
                                                    </td>

                                                    <td><?= esc($estudi['nom']) ?></td>

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
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                            Tornar
                        </a>

                        <button type="submit"
                            id="btnAlternar"
                            name="accio"
                            value="alternar"
                            class="btn btn-outline-primary"
                            disabled>
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

        const botoAlternar = document.getElementById('btnAlternar');

        botoAlternar.addEventListener('click', function(e) {
            e.preventDefault();

            const caselles = document.querySelectorAll('input[name="estudis[]"]');

            caselles.forEach(casella => {
                casella.checked = !casella.checked;
            });
        });

    });
</script>

<?= view('layouts/footer') ?>