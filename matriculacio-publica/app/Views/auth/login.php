<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessió</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/login.css') ?>">
</head>

<body>
    <div class="login-container">
        <h2 class="login-title">Iniciar Sessió</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('/auth/dologin') ?>" id="loginForm">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="dniInput" class="form-label">DNI / NIE</label>
                <input type="text" 
                       name="dni" 
                       class="form-control <?= session('errors.dni') ? 'is-invalid' : '' ?>" 
                       id="dniInput" 
                       data-validate="dni"
                       placeholder="Introdueix el teu DNI"
                       maxlength="9"
                       value="<?= old('dni') ?>"
                       required>
                <div class="invalid-feedback">
                    <?= session('errors.dni') ?? '' ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="codiInput" class="form-label">Codi d'accés</label>
                <input type="text" 
                       name="codi" 
                       class="form-control <?= session('errors.codi') ? 'is-invalid' : '' ?>" 
                       id="codiInput" 
                       placeholder="Codi de 6 dígits"
                       maxlength="6"
                       value="<?= old('codi') ?>"
                       required>
                <div class="invalid-feedback">
                    <?= session('errors.codi') ?? '' ?>
                </div>
                <div class="form-text">Introdueix el codi rebut al teu correu electrònic</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Iniciar Sessió</button>
            
            <div class="text-center mt-3">
                <a href="<?= base_url('auth/signin') ?>" class="text-decoration-none">Registrar-se</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dni-validator.js') ?>"></script>
    <script src="<?= base_url('assets/js/form-validator.js') ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicialitzar validació
        FormValidator.init('#loginForm');
        
        // Validació DNI en temps real
        const dniInput = document.getElementById('dniInput');
        DNIValidator.bindToInput(dniInput);

        // Només permetre números al codi
        const codiInput = document.getElementById('codiInput');
        codiInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    </script>
</body>

</html>