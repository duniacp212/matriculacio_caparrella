<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 border-bottom-lila bg-white">
        <h4 class="mb-0">Configuració de la Interfície</h4>
    </div>

    <div class="row flex-grow-1 g-0 mt-3">

        <?= view('layouts/aside') ?>

        <main class="col-10 pt-0 px-3 overflow-auto">

            <div class="card mt-2 shadow-sm border-0">
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
                                    <input class="form-check-input" type="checkbox" name="config[menu_calendari]" <?= $config['menu_calendari'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Calendari</label>
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

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Desar configuració</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

<?= view('layouts/footer') ?>