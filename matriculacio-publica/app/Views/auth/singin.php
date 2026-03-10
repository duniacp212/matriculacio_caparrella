<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sign In</title>
    <link rel="stylesheet" href="<?= base_url('assets/singin.css') ?>">
</head>

<body>
    <div class="singIn-container">
        <h2 class="singIn-title">Registrar-se</h2>
        <form method="POST" action="<?= base_url('/auth/register') ?>">
            <div class="mb-3">
                <label for="dniInput" class="form-label">DNI / NIE</label>
                <input type="text" class="form-control DNIuser" id="dniInput" name="dni" placeholder="Exemple: 12345678A"
                    maxlength="9" required>
                <div class="form-text">Introdueix el teu DNI o NIE</div>
            </div>
            <div class="mb-3">
                <label for="mailInput" class="form-label">Correu electrònic</label>
                <input type="email" class="form-control mailuser" id="mailInput" name="email" placeholder="exemple@correu.com"
                    required>
                <div class="form-text">Utilitzarem aquest correu per contactar-te</div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar-se</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>