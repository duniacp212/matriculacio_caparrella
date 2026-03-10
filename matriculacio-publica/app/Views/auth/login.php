<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS personalitzat -->
    <link rel="stylesheet" href="<?= base_url('assets/login.css') ?>">
</head>

<body>
    <div class="login-container">
        <h2 class="login-title">Iniciar Sessió</h2>
        <form method="POST" action="<?= base_url('/auth/dologin') ?>">
            <div class="mb-3">
                <label for="dniInput" class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control DNIuser" id="dniInput" placeholder="Introdueix el teu DNI">
            </div>
            <div class="mb-3">
                <label for="codiInput" name="codi" class="form-label">Codi</label>
                <input type="password" class="form-control CODIuser" id="codiInput" placeholder="Introdueix el codi">
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>