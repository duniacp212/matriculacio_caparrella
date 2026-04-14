<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrar-se</title>
    <link rel="stylesheet" href="<?= base_url('assets/singin.css') ?>">
</head>

<body>
    <div class="singIn-container">
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
            <button type="submit" name="action" value="login" class="btn btn-secondary"> Iniciar sessió</button>
            <button type="submit" name="action" value="register" class="btn btn-primary w-100">Registrar-se</button>
        </form>
        <form method="POST" action="<?= base_url('/auth/register') ?>" id="registerForm">
            <?= csrf_field() ?>
            <div class="d-grid gap-2">
                <button type="submit" name="action" value="register" class="btn btn-primary">Registrar-se / Enviar Codi</button>
                <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-secondary">Ja tinc un codi (Anar al Login)</a>
            </div>
        </form>
    </div>

    <div class="container mt-5 mb-5">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark"><strong>ZONA DE DEBUG:</strong> Alumnes registrats a la BDD</div>
            <div class="card-body">
                <p class="small text-muted">Aquesta taula mostra els alumnes que han passat el filtre del CSV i ja tenen un codi generat.</p>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Email</th>
                                <th>Codi Accés</th>
                                <th>Estat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($alumnesBDD)): ?>
                                <?php foreach($alumnesBDD as $a): ?>
                                    <tr>
                                        <td><code><?= $a['dni'] ?></code></td>
                                        <td><?= $a['email'] ?></td>
                                        <td><span class="badge bg-success" style="font-size: 1.1em;"><?= $a['codi'] ?></span></td>
                                        <td><?= $a['estat'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center">No hi ha alumnes a la BDD. Registra'n un fent servir els DNI del CSV.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

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