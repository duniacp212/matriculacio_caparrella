<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonificacions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/forms.css') ?>">
</head>
<body>
    <div class="background-decoration"></div>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1 class="form-title">Bonificacions</h1>
                <p class="form-subtitle">Selecciona les bonificacions que t'apliquen</p>
            </div>

            <form action="<?= base_url('forms/saveBonificacions') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <?php if (empty($bonificacions)): ?>
                    <p class="text-muted">No hi ha bonificacions disponibles.</p>
                <?php else: ?>
                    <?php foreach ($bonificacions as $b): ?>
                        <div class="mb-3 p-3 border rounded">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="bonificacions[]"
                                    value="<?= esc($b['id_bonificacio']) ?>"
                                    id="bonificacio_<?= esc($b['id_bonificacio']) ?>"
                                >
                                <label class="form-check-label fw-semibold" for="bonificacio_<?= esc($b['id_bonificacio']) ?>">
                                    <?= esc($b['nom']) ?>
                                    <span class="badge bg-primary ms-2"><?= esc($b['percentatge']) ?>%</span>
                                </label>
                            </div>

                            <?php if (!empty($b['descripcio'])): ?>
                                <p class="text-muted small mt-1 mb-2"><?= esc($b['descripcio']) ?></p>
                            <?php endif; ?>

                            <div class="mt-2 document-upload" id="upload_<?= esc($b['id_bonificacio']) ?>" style="display:none;">
                                <label class="form-label small">Document acreditatiu</label>
                                <input
                                    type="file"
                                    class="form-control form-control-sm"
                                    name="documents[<?= esc($b['id_bonificacio']) ?>]"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                >
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="form-actions">
                    <a href="<?= base_url('forms/documentacio') ?>" class="btn btn-anterior btn-lg">Anterior</a>
                    <button type="submit" class="btn btn-primary btn-lg">Següent</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostra/amaga el camp de document quan es marca el checkbox
        document.querySelectorAll('input[name="bonificacions[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const id = this.value;
                const uploadDiv = document.getElementById('upload_' + id);
                if (uploadDiv) {
                    uploadDiv.style.display = this.checked ? 'block' : 'none';
                }
            });
        });
    </script>
</body>
</html>