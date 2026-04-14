<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('estils.css') ?>?v=<?= time() ?>">
</head>

<body class="bg-light">

    <div class="container vh-100 d-flex align-items-center justify-content-center">

        <div class="card shadow p-4" style="width:400px; min-height:550px;">

            <div class="text-center mb-3">
                <img src="<?= base_url('logo.png') ?>" alt="Logo Institut Caparrella" style="width:280px;">
            </div>

            <h4 class="text-center mb-4" style="color: var(--caparrella-lila);">Accés administració</h4>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('login') ?>">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Usuari</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contrasenya</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">
                    Entrar
                </button>

            </form>

        </div>

    </div>

    <?= view('layouts/footer') ?>

</body>

</html>