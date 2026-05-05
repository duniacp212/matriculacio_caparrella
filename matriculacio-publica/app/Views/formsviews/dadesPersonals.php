<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulari d'Inscripció d'Alumne</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Barlow+Condensed:wght@600;700&display=swap"
        rel="stylesheet">

    <!-- CSS personalitzat -->
    <link rel="stylesheet" href="<?= base_url('assets/forms.css') ?>">
</head>

<body>
    <div class="background-decoration"></div>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1 class="form-title">Inscripció d'Alumne</h1>
                <p class="form-subtitle">Completa les dades per formalitzar la matrícula</p>
            </div>

            <form id="studentForm">

                <!-- Dades Personals -->
                <div class="section-divider">
                    <span class="section-title">Dades Personals</span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nom" placeholder="Nom">
                            <label for="nom">Nom</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="cognoms" placeholder="Cognoms">
                            <label for="cognoms">Cognoms</label>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="dataNaixement" placeholder="Data de naixement">
                            <label for="dataNaixement">Data de Naixement</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="poblacioNaixement"
                                placeholder="Població de naixement">
                            <label for="poblacioNaixement">Població de Naixement</label>
                        </div>
                    </div>
                </div>

                <!-- Dades de Contacte -->
                <div class="section-divider">
                    <span class="section-title">Contacte</span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="telefon" placeholder="Telèfon">
                            <label for="telefon">Telèfon Alumne</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="correu" placeholder="Correu electrònic">
                            <label for="correu">Correu Alumne</label>
                        </div>
                    </div>
                </div>

                <!-- Adreça -->
                <div class="section-divider">
                    <span class="section-title">Adreça</span>
                </div>

                <div class="mb-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="adreca" placeholder="Adreça">
                        <label for="adreca">Adreça</label>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="municipi" placeholder="Municipi">
                            <label for="municipi">Municipi</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="codiPostal" placeholder="Codi Postal">
                            <label for="codiPostal">Codi Postal</label>
                        </div>
                    </div>
                </div>

                <!-- Botons -->
                <div class="form-actions">
                    <button type="reset" class="btn btn-outline-secondary btn-lg">Desar</button>
                    <a href="<?= base_url('forms/dadesTutors') ?>" class="btn btn-primary btn-lg">Següent</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>