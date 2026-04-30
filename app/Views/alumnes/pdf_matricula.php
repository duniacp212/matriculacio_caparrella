<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Resguard de Matrícula - <?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #444;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #222;
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header h2 {
            margin: 4px 0 0 0;
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }
        .header .data-emisio {
            font-size: 11px;
            color: #888;
            margin-top: 4px;
        }
        .section {
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .section-title {
            font-weight: bold;
            font-size: 12px;
            background-color: #f0f0f0;
            padding: 6px 12px;
            border-bottom: 1px solid #ccc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            padding: 10px 12px;
        }
        th, td {
            padding: 5px 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            width: 38%;
            color: #666;
            font-weight: normal;
        }
        td {
            font-weight: bold;
        }
        .badge {
            border: 1px solid #999;
            padding: 1px 6px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-success { border-color: #28a745; color: #28a745; }
        .badge-warning { border-color: #dc3545; color: #dc3545; }
        .tutor-row {
            padding: 6px 12px;
            border-bottom: 1px solid #eee;
        }
        .tutor-row:last-child { border-bottom: none; }
        .tutor-nom { font-weight: bold; }
        .tutor-info { color: #555; font-size: 11px; }
        .observacions-box {
            padding: 8px 12px;
            font-style: italic;
            color: #444;
            min-height: 40px;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px dashed #ccc;
            padding-top: 12px;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
        .firma-box {
            margin-top: 35px;
            display: table;
            width: 100%;
        }
        .firma-col {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding-top: 10px;
        }
        .firma-line {
            border-top: 1px solid #555;
            width: 70%;
            margin: 0 auto 5px auto;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Resguard de Matrícula</h1>
        <h2>Institut Caparrella · Lleida</h2>
        <div class="data-emisio">Data d'emissió: <?= date('d/m/Y H:i') ?></div>
    </div>

    <!-- DADES PERSONALS -->
    <div class="section">
        <div class="section-title">Dades personals</div>
        <table>
            <tr>
                <th>Nom complet:</th>
                <td><?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?> <?= esc($alumne->cognom2 ?? '') ?></td>
            </tr>
            <tr>
                <th>DNI / NIE:</th>
                <td><?= esc($alumne->dni) ?></td>
            </tr>
            <tr>
                <th>Data de naixement:</th>
                <td><?= !empty($alumne->data_naixement) ? date('d/m/Y', strtotime($alumne->data_naixement)) : '—' ?></td>
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

    <!-- CONTACTE -->
    <div class="section">
        <div class="section-title">Dades de contacte</div>
        <table>
            <tr>
                <th>Adreça:</th>
                <td>
                    <?php
                    $adreca = trim(($alumne->carrer ?? '') . ' ' . ($alumne->numero ?? '') . ' ' . ($alumne->pis ?? ''));
                    echo !empty(trim($adreca)) ? esc($adreca) : '—';
                    ?>
                </td>
            </tr>
            <tr>
                <th>Codi postal / Població:</th>
                <td><?= esc(($alumne->codi_postal ?? '') . ' ' . ($alumne->poblacio ?? '')) ?></td>
            </tr>
            <tr>
                <th>Telèfon:</th>
                <td><?= !empty($alumne->telefon) ? esc($alumne->telefon) : '—' ?><?= !empty($alumne->telefon2) ? ' / ' . esc($alumne->telefon2) : '' ?></td>
            </tr>
            <tr>
                <th>Correu electrònic:</th>
                <td><?= !empty($alumne->email) ? esc($alumne->email) : '—' ?></td>
            </tr>
        </table>
    </div>

    <!-- DADES DE LA MATRÍCULA -->
    <div class="section">
        <div class="section-title">Dades de la matrícula</div>
        <table>
            <tr>
                <th>Estudi:</th>
                <td><?= esc($alumne->tipus ?? '—') ?></td>
            </tr>
            <tr>
                <th>Curs:</th>
                <td><?= esc($alumne->nivell ?? '—') ?></td>
            </tr>
            <tr>
                <th>Torn:</th>
                <td><?= !empty($matricula->torn) ? 'Torn ' . esc($matricula->torn) : '—' ?></td>
            </tr>
            <tr>
                <th>Any acadèmic:</th>
                <td><?= esc($alumne->any_matricula ?? '—') ?></td>
            </tr>
            <tr>
                <th>Estat:</th>
                <td>
                    <?php $estat = $matricula->estat ?? 'Pendent'; ?>
                    <span class="badge <?= $estat === 'Validat' ? 'badge-success' : 'badge-warning' ?>">
                        <?= esc($estat) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th>Data de pagament:</th>
                <td>
                    <?php if (!empty($matricula->data_pagament)): ?>
                        <span class="badge badge-success"><?= esc($matricula->data_pagament) ?></span>
                    <?php else: ?>
                        <span class="badge badge-warning">No pagat</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Bonificació:</th>
                <td>
                    <?php if (!empty($matricula->bonificacio_nom)): ?>
                        <?= esc($matricula->bonificacio_nom) ?> (<?= esc($matricula->bonificacio_percentatge) ?>%)
                    <?php else: ?>
                        Sense bonificació
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- TUTORS LEGALS -->
    <?php if (!empty($tutors)): ?>
    <div class="section">
        <div class="section-title">Tutors legals / Representants</div>
        <?php foreach ($tutors as $tutor): ?>
        <div class="tutor-row">
            <div class="tutor-nom"><?= esc($tutor->nom) ?> <?= esc($tutor->cognom1) ?> — <em><?= esc($tutor->rol) ?></em></div>
            <div class="tutor-info">
                DNI: <?= esc($tutor->dni ?? '—') ?>
                <?= !empty($tutor->telefon) ? ' · Tel: ' . esc($tutor->telefon) : '' ?>
                <?= !empty($tutor->email) ? ' · ' . esc($tutor->email) : '' ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- OBSERVACIONS -->
    <?php if (!empty($matricula->observacions)): ?>
    <div class="section">
        <div class="section-title">Observacions</div>
        <div class="observacions-box"><?= nl2br(esc($matricula->observacions)) ?></div>
    </div>
    <?php endif; ?>

    <!-- SIGNATURES -->
    <div class="firma-box">
        <div class="firma-col">
            <div class="firma-line"></div>
            <div>Signatura de l'alumne/a o tutor/a</div>
        </div>
        <div class="firma-col">
            <div class="firma-line"></div>
            <div>Segell i signatura del centre</div>
        </div>
    </div>

    <div class="footer">
        Document generat automàticament per l'Institut Caparrella · Conserveu aquest resguard
    </div>

</body>
</html>
