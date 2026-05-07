<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Verificació 2FA - Matriculació INS Caparrella</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card p-4">
                <h2 class="text-center mb-4">Verificació de Seguretat</h2>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <p class="text-center">Introdueix el codi de 6 dígits de la teva aplicació autenticadora per completar l'inici de sessió.</p>
                
                <form action="<?= base_url('2fa/validar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <input type="text" name="codi" class="form-control form-control-lg text-center" placeholder="000 000" required autofocus autocomplete="off" pattern="\d{6}">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Verificar</button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <a href="<?= base_url('logout') ?>" class="text-decoration-none">Tornar al login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
