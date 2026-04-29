<?php
$urlActual = current_url();
$segmentAuto = '';
if (strpos($urlActual, 'eso') !== false)
    $segmentAuto = 'eso';
elseif (strpos($urlActual, 'batxillerat') !== false)
    $segmentAuto = 'batxillerat';
elseif (strpos($urlActual, 'fp-gm') !== false)
    $segmentAuto = 'fp-gm';
elseif (strpos($urlActual, 'fp-gs') !== false)
    $segmentAuto = 'fp-gs';
elseif (strpos($urlActual, 'fp-basica') !== false)
    $segmentAuto = 'fp-basica';
elseif (strpos($urlActual, 'pfi') !== false)
    $segmentAuto = 'pfi';
?>

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

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form id="formCursos" method="post" action="<?= base_url('gestio/processar') ?>">

             <?= csrf_field() ?>

                <div class="d-flex justify-content-end gap-2 mb-3">
                    <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4 me-auto">Tornar</a>
                    <button type="submit" name="accio" value="duplicar" class="btn btn-outline-secondary btn-sm action-btn">Duplicar</button>
                    <button type="submit" name="accio" value="eliminar" class="btn btn-outline-danger btn-sm action-btn">Eliminar</button>
                    <button type="submit" name="accio" value="editar" class="btn btn-outline-primary btn-sm action-btn">Editar</button>

                    <a href="<?= base_url('gestio/nou-curs/' . $segmentAuto) ?>" class="btn btn-outline-primary btn-sm">Afegir curs</a>

                    <button type="submit" name="accio" value="afegir-assignatura" class="btn btn-success btn-sm action-btn">Afegir assignatura</button>
                </div>

                <?php if (empty($cursos)): ?>
                    <div class="alert alert-info">
                        No hi ha cursos disponibles d'aquesta categoria.
                    </div>
                <?php else: ?>
                    <?php $primer = true; ?>
                    <?php foreach ($cursos as $curs): ?>
                        <div class="card mb-4 shadow-sm card-lila">
                            <details <?= $primer ? 'open' : '' ?>>
                                <?php $primer = false; ?>
                                <summary class="resum-lila">
                                    <input type="checkbox" name="cursos[]" value="<?= esc($curs['id_estudi']) ?>" class="curso-checkbox" />
                                    <?= esc($curs['nivell']) ?> &nbsp;&nbsp;&nbsp; <?= esc($curs['tipus']) ?>
                                </summary>

                                <div class="card-body">
                                    <h6 class="text-secondary fw-semibold mb-3">Assignatures / Mòduls</h6>
                                    <div class="row g-2 mb-4">
                                        <?php if (empty($curs['assignatures'])): ?>
                                            <div class="col-12 text-muted">No s'han trobat assignatures.</div>
                                        <?php else: ?>
                                            <?php foreach ($curs['assignatures'] as $assignatura): ?>
                                                <div class="col-md-4">
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="assignatures[]"
                                                            value="<?= esc($assignatura['id_assignatura']) ?>" class="item-checkbox" />
                                                        <?= esc($assignatura['nom']) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>

                                    <h6 class="text-secondary fw-semibold mb-3">Assignatures Optatives</h6>
                                    <div class="row g-2">
                                        <?php if (empty($curs['optatives'])): ?>
                                            <div class="col-12 text-muted">No s'han trobat optatives.</div>
                                        <?php else: ?>
                                            <?php foreach ($curs['optatives'] as $optativa): ?>
                                                <div class="col-md-4">
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="optatives[]"
                                                            value="<?= esc($optativa['id_optativa']) ?>" class="item-checkbox" />
                                                        <?= esc($optativa['nom']) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </details>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </form>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formCursos');
    const actionButtons = document.querySelectorAll('.action-btn');

    actionButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const action = this.value;
            const checkedCourses = document.querySelectorAll('.curso-checkbox:checked');
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            const totalChecked = checkedCourses.length + checkedItems.length;

            if (totalChecked === 0) {
                e.preventDefault();
                alert('Si us plau, selecciona almenys un element per realitzar aquesta acció.');
                return;
            }

            if (action === 'eliminar') {
                if (!confirm('Estàs segur que vols eliminar els elements seleccionats?')) {
                    e.preventDefault();
                }
            }

            if (action === 'editar' && checkedCourses.length === 0) {
                e.preventDefault();
                alert('Selecciona un curs per poder editar-lo.');
            }
        });
    });
});
</script>

<?= view('layouts/footer') ?>