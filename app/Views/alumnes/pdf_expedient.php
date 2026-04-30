<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title><?= esc($tipus) ?> - <?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #6f42c1;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #6f42c1;
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #555;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #f8f9fa;
            border-left: 4px solid #6f42c1;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f4f4f4;
            width: 30%;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Institut Caparrella</h1>
        <h2><?= esc($tipus) ?></h2>
        <p>Data d'emissió: <?= date('d/m/Y H:i') ?></p>
    </div>

    <div class="section">
        <div class="section-title">Dades Personals</div>
        <table>
            <tr>
                <th>Nom complet:</th>
                <td><?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?> <?= esc($alumne->cognom2) ?></td>
            </tr>
            <tr>
                <th>DNI / NIE:</th>
                <td><?= esc($alumne->dni) ?></td>
            </tr>
            <tr>
                <th>Data de naixement:</th>
                <td><?= $alumne->data_naixement ? date('d/m/Y', strtotime($alumne->data_naixement)) : '—' ?></td>
            </tr>
            <tr>
                <th>Lloc de naixement:</th>
                <td><?= esc($alumne->lloc_naixement ?? '—') ?></td>
            </tr>
            <tr>
                <th>Nacionalitat:</th>
                <td><?= esc($alumne->nacionalitat ?? '—') ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Dades de Contacte</div>
        <table>
            <tr>
                <th>Telèfons:</th>
                <td><?= esc($alumne->telefon ?? '—') ?> <?= $alumne->telefon2 ? ' / '.esc($alumne->telefon2) : '' ?></td>
            </tr>
            <tr>
                <th>Correu electrònic:</th>
                <td><?= esc($alumne->email ?? '—') ?></td>
            </tr>
            <tr>
                <th>Adreça:</th>
                <td><?= !empty(trim((string)$alumne->carrer)) ? esc($alumne->carrer) . ' ' . esc($alumne->numero) . ' ' . esc($alumne->pis) : '—' ?></td>
            </tr>
            <tr>
                <th>Població:</th>
                <td><?= !empty(trim((string)$alumne->poblacio)) ? esc($alumne->poblacio) . ' (' . esc($alumne->codi_postal) . ')' : '—' ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Dades Acadèmiques i Matrícula</div>
        <table>
            <tr>
                <th>Estudi i Curs:</th>
                <td><?= esc($alumne->tipus ?? '—') ?> - Curs <?= esc($alumne->nivell ?? '—') ?></td>
            </tr>
            <tr>
                <th>Any acadèmic:</th>
                <td><?= esc($alumne->any_matricula ?? '—') ?></td>
            </tr>
            <tr>
                <th>Torn:</th>
                <td><?= !empty($alumne->torn) ? 'Torn ' . esc($alumne->torn) : '—' ?></td>
            </tr>
            <tr>
                <th>Estat de la matrícula:</th>
                <td><?= esc($alumne->estat ?? 'Pendent') ?></td>
            </tr>
            <tr>
                <th>Bonificació associada:</th>
                <td><?= esc($alumne->bonificats ?? '0') ?>%</td>
            </tr>
        </table>
    </div>

    <?php if (!empty($tutors)): ?>
    <div class="section">
        <div class="section-title">Tutors Legals</div>
        <table>
            <?php foreach($tutors as $tutor): ?>
            <tr>
                <th><?= esc($tutor['rol']) ?>:</th>
                <td><?= esc($tutor['nom']) ?> <?= esc($tutor['cognom1']) ?> (DNI: <?= esc($tutor['dni']) ?>)<br>
                <strong>Telèfon:</strong> <?= esc($tutor['telefon']) ?> | <strong>Email:</strong> <?= esc($tutor['email']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>

    <div class="section">
        <div class="section-title">Observacions Enregistrades</div>
        <div style="padding: 10px; border: 1px solid #ddd; background-color: #fcfcfc;">
            <?php
            $historial = !empty($alumne->observacions) ? json_decode($alumne->observacions, true) : [];
            if (empty($alumne->observacions)): ?>
                Sense observacions registrades.
            <?php elseif (is_array($historial)): ?>
                <ul style="margin: 0; padding-left: 15px;">
                <?php foreach ($historial as $obs): ?>
                    <li style="margin-bottom: 5px;"><strong>[<?= date('d/m/Y', strtotime($obs['data'])) ?>]:</strong> <?= esc($obs['text']) ?></li>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <?= esc($alumne->observacions) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        Aquest document té validesa informativa i ha estat generat de forma segura mitjançant el sistema de gestió de l'Institut Caparrella. (<?= date('Y') ?>)
    </div>

</body>
</html>
