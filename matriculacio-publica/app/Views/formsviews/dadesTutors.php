<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulari de Dades dels Tutors</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=DM+Serif+Display&display=swap"
        rel="stylesheet">

    <!-- CSS personalitzat -->
    <link rel="stylesheet" href="<?= base_url('assets/forms.css') ?>">
</head>

<body>
    <div class="background-decoration"></div>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1 class="form-title">Dades dels Tutors</h1>
                <p class="form-subtitle">Informació de contacte dels tutors legals</p>
            </div>

            <form id="tutorsForm">

                <!-- Tutor 1 -->
                <div class="section-divider">
                    <span class="section-title">Tutor 1</span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nomTutor1" placeholder="Nom Tutor 1">
                            <label for="nomTutor1">Nom Tutor 1</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="cognomsTutor1" placeholder="Cognoms Tutor 1">
                            <label for="cognomsTutor1">Cognoms Tutor 1</label>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="telefonTutor1" placeholder="Telèfon Tutor 1">
                            <label for="telefonTutor1">Telèfon Tutor 1</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="correuTutor1" placeholder="Correu Tutor 1">
                            <label for="correuTutor1">Correu Tutor 1</label>
                        </div>
                    </div>
                </div>

                <!-- Tutor 2 -->
                <div class="section-divider">
                    <span class="section-title">Tutor 2</span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nomTutor2" placeholder="Nom Tutor 2">
                            <label for="nomTutor2">Nom Tutor 2</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="cognomsTutor2" placeholder="Cognoms Tutor 2">
                            <label for="cognomsTutor2">Cognoms Tutor 2</label>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="telefonTutor2" placeholder="Telèfon Tutor 2">
                            <label for="telefonTutor2">Telèfon Tutor 2</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="correuTutor2" placeholder="Correu Tutor 2">
                            <label for="correuTutor2">Correu Tutor 2</label>
                        </div>
                    </div>
                </div>

                <!-- Circumstàncies especials i Situacions singulars -->
                <div class="section-divider">
                    <span class="section-title">Informació Addicional</span>
                </div>

                <div class="mb-4">
                    <div class="form-floating">
                        <textarea class="form-control textarea-custom" id="circumstanciesEspecials"
                            placeholder="Circumstàncies Especials"></textarea>
                        <label for="circumstanciesEspecials">Circumstàncies Especials</label>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-floating">
                        <textarea class="form-control textarea-custom" id="situacionsSingulars"
                            placeholder="Situacions Singulars"></textarea>
                        <label for="situacionsSingulars">Situacions Singulars</label>
                    </div>
                </div>

                <!-- Botons -->
                <div class="form-actions">
                    <a href="<?= base_url('forms/dadesPersonals') ?>" class="btn btn-anterior btn-lg">Anterior</a>
                    <button type="reset" class="btn btn-outline-secondary btn-lg">Desar</button>
                    <!-- logicca per guardar com un esborrany -->
                    <!-- <button type="submit" class="btn btn-primary btn-lg">Següent</button> -->
                    <a href="<?= base_url('forms/dadesCicle') ?>" class="btn btn-primary btn-lg">Següent</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>