<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 bg-white">
        <div class="row align-items-center">
            <div class="col-12">
                 <h4 class="mb-0">Configuració de la Interfície</h4>
            </div>
        </div>
    </div>

    <div class="row flex-grow-1 g-0 mt-3">

        <main class="col-12 pt-0 px-3 overflow-auto">

            <?php if (session()->getFlashdata('exit')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3 py-2 small" role="alert">
                    <?= session()->getFlashdata('exit') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-start mb-3">
                 <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="<?= base_url('configuracio/guardar') ?>" method="post">
                        <?= csrf_field() ?>

                        <h5 class="mb-3">Elements del Menú</h5>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[menu_alumnes_matriculats]" <?= $config['menu_alumnes_matriculats'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Alumnes matriculats</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[menu_gestio_cursos]" <?= $config['menu_gestio_cursos'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Gestió de cursos</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[menu_matricula_viva]" <?= $config['menu_matricula_viva'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Matrícula viva</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[menu_usuaris]" <?= $config['menu_usuaris'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Gestió d'usuaris</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[menu_calendari]" <?= ($config['menu_calendari'] ?? 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label">Calendari</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[menu_serveis_complementaris]" <?= ($config['menu_serveis_complementaris'] ?? 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label">Serveis complementaris</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[menu_bonificacions]" <?= ($config['menu_bonificacions'] ?? 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label">Gestió de bonificacions</label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Filtres de Cerca (Alumnes)</h5>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[filtre_any]" <?= $config['filtre_any'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Filtre: Any</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[filtre_estudi]" <?= $config['filtre_estudi'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Filtre: Estudi</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[filtre_curs]" <?= $config['filtre_curs'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Filtre: Curs</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[filtre_torn]" <?= $config['filtre_torn'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Filtre: Torn</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[filtre_estat]" <?= $config['filtre_estat'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Filtre: Estat</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[filtre_pagament]" <?= $config['filtre_pagament'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Filtre: Pagament</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="config[filtre_bonificacio]" <?= $config['filtre_bonificacio'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Filtre: Bonificació</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end border-top pt-3">
                            <button type="submit" class="btn btn-primary btn-sm px-4">Desar configuració</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>