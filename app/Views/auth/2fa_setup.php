<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Configurar 2FA - Matriculació INS Caparrella</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        #qrcode img { margin: 0 auto; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h2 class="text-center mb-4">Configurar Doble Factor (2FA)</h2>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <p>1. Escaneja aquest codi QR amb la teva aplicació d'autenticació (Google Authenticator, Authy, etc.):</p>
                
                <div id="qrcode" class="text-center my-4"></div>
                
                <p class="text-muted small text-center">Secret manual: <code><?= $secret ?></code></p>
                
                <hr>
                
                <p>2. Introdueix el codi de 6 dígits que apareix al teu mòbil per confirmar l'activació:</p>
                
                <form action="<?= base_url('2fa/activar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="text" name="codi" class="form-control form-control-lg text-center" placeholder="000000" required autocomplete="off" autofocus pattern="\d{6}">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Activar 2FA</button>
                        <a href="<?= base_url('perfil') ?>" class="btn btn-outline-secondary">Cancel·lar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script type="text/javascript">
    new QRCode(document.getElementById("qrcode"), {
        text: "<?= $qrCodeUri ?>",
        width: 200,
        height: 200
    });
</script>
</body>
</html>
