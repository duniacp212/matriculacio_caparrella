<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrar-se</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/singin.css') ?>">
</head>

<body>
    <div class="singIn-container">
    <div class="singIn-header-band">
        <div class="school-logo-area">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" width="38" height="38">
  <rect width="64" height="64" rx="10" fill="#1a3a6b"/>
  <polygon points="32,10 58,24 32,32 6,24" fill="#f5a623"/>
  <polygon points="32,13 55,25 32,30 9,25" fill="#ffc340"/>
  <rect x="50" y="24" width="2.5" height="12" fill="#f5a623"/>
  <rect x="48" y="36" width="7" height="2" fill="#f5a623"/>
  <rect x="16" y="33" width="32" height="20" rx="1" fill="#2a5298"/>
  <rect x="20" y="36" width="6" height="14" fill="#1a3a6b"/>
  <rect x="29" y="36" width="6" height="14" fill="#1a3a6b"/>
  <rect x="38" y="36" width="6" height="14" fill="#1a3a6b"/>
  <rect x="27" y="44" width="10" height="9" rx="1" fill="#f5a623"/>
</svg>
            <div class="school-name">
                Institut Caparrella
                <span>Lleida · Catalunya</span>
            </div>
        </div>
    </div>
    <div class="body-content">
        <h2 class="singIn-title">Registrar-se</h2>
        
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

        <form method="POST" action="<?= base_url('/auth/register') ?>" id="registerForm">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="dniInput" class="form-label">DNI / NIE</label>
                <input type="text" 
                       class="form-control <?= session('errors.dni') ? 'is-invalid' : '' ?>" 
                       id="dniInput" 
                       name="dni" 
                       data-validate="dni"
                       placeholder="Exemple: 12345678A"
                       maxlength="9" 
                       value="<?= old('dni') ?>"
                       required>
                <div class="invalid-feedback">
                    <?= session('errors.dni') ?? '' ?>
                </div>
                <div class="form-text">Introdueix el teu DNI o NIE</div>
            </div>

            <div class="mb-3">
                <label for="mailInput" class="form-label">Correu electrònic</label>
                <input type="email" 
                       class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                       id="mailInput" 
                       name="email" 
                       placeholder="exemple@correu.com"
                       value="<?= old('email') ?>"
                       required>
                <div class="invalid-feedback">
                    <?= session('errors.email') ?? '' ?>
                </div>
                <div class="form-text">Utilitzarem aquest correu per enviar-te el codi d'accés</div>
            </div>
            <button type="submit" name="action" value="login" class="btn btn-primary w-100"> Iniciar sessió</button>
        </form>
    
    </div>

    </div><!-- /body-content -->
    </div><!-- /singIn-container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dni-validator.js') ?>"></script>
    <script src="<?= base_url('assets/js/form-validator.js') ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicialitzar validació
        FormValidator.init('#registerForm');
        
        // Validació DNI en temps real
        const dniInput = document.getElementById('dniInput');
        DNIValidator.bindToInput(dniInput);
    });
    </script>
</body>

</html>