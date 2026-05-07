<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Expedient - <?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 20px;
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px 12px;
            text-align: left;
            vertical-align: top;
        }

        th {
            width: 35%;
            color: #666;
            font-weight: normal;
        }

        td {
            font-weight: bold;
        }

        .tutor-row {
            padding: 6px 12px;
            border-bottom: 1px solid #eee;
        }

        .tutor-row:last-child {
            border-bottom: none;
        }

        .tutor-nom {
            font-weight: bold;
        }

        .tutor-info {
            color: #555;
            font-size: 11px;
        }

        .badge {
            border: 1px solid #999;
            padding: 1px 6px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-success {
            border-color: #28a745;
            color: #28a745;
        }

        .badge-warning {
            border-color: #dc3545;
            color: #dc3545;
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
        <h2>Expedient de l'Alumne</h2>
        <div class="data-emisio">Data d'emissió: <?= date('d/m/Y H:i') ?></div>
    </div>

    <div class="section">
        <div class="section-title">Dades personals</div>
        <table>
            <tr>
                <th>Nom complet:</th>
                <td><?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?> <?= !empty($alumne->cognom2) ? esc($alumne->cognom2) : '—' ?></td>
            </tr>
            <tr>
                <th>DNI / NIE:</th>
                <td><?= esc($alumne->dni) ?></td>
            </tr>
            <tr>
                <th>Data de naixement:</th>
                <td><?= !empty($alumne->data_naixement) ? date('d/m/Y', strtotime($alumne->data_naixement)) : '—' ?>
                </td>
            </tr>
            <tr>
                <th>Lloc de naixement:</th>
                <td><?= esc($alumne->lloc_naixement ?? '—') ?></td>
            </tr>
            <tr>
                <th>Nacionalitat:</th>
                <td><?= esc($alumne->nacionalitat ?? '—') ?></td>
            </tr>
            <tr>
                <th>Telèfons:</th>
                <td><?= !empty($alumne->telefon) ? esc($alumne->telefon) : '—' ?><?= !empty($alumne->telefon2) ? ' / ' . esc($alumne->telefon2) : '' ?>
                </td>
            </tr>
            <tr>
                <th>Correu electrònic:</th>
                <td><?= !empty($alumne->email) ? esc($alumne->email) : '—' ?></td>
            </tr>
            <tr>
                <th>Adreça:</th>
                <td>
                    <?php
                    $adreca = trim(($alumne->carrer ?? '') . ' ' . ($alumne->numero ?? '') . ' ' . ($alumne->pis ?? ''));
                    echo !empty($adreca) ? esc($adreca) : '—';
                    ?>
                </td>
            </tr>
            <tr>
                <th>Codi postal:</th>
                <td><?= esc($alumne->codi_postal ?? '—') ?></td>
            </tr>
            <tr>
                <th>Població:</th>
                <td><?= esc($alumne->poblacio ?? '—') ?></td>
            </tr>
        </table>
    </div>

    <?php if (!empty($matricules)): ?>
        <?php foreach ($matricules as $m): ?>
            <div class="section">
                <div class="section-title">Dades acadèmiques - <?= $m['any_academic'] ?></div>
                <table>
                    <tr>
                        <th style="width: 35%">Estudi:</th>
                        <td><?= esc($m['estudi']) ?></td>
                    </tr>
                    <tr>
                        <th>Curs:</th>
                        <td>
                            <?php 
                                $c = $m['curs'];
                                $sufix = is_numeric($c) ? ($c == 1 ? 'r' : ($c == 2 ? 'n' : ($c == 3 ? 'r' : 't'))) : '';
                                echo esc($c . $sufix) . ' curs';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Torn:</th>
                        <td>Torn <?= esc($m['torn']) ?></td>
                    </tr>
                    <tr>
                        <th>Estat matrícula:</th>
                        <td><?= esc($m['estat']) ?></td>
                    </tr>
                    <tr>
                        <th>Data pagament:</th>
                        <td><?= $m['data_pagament'] ? date('d/m/Y', strtotime($m['data_pagament'])) : 'Pendent' ?></td>
                    </tr>
                    <tr>
                        <th>Bonificació:</th>
                        <td><?= $m['bonificacio_nom'] ? esc($m['bonificacio_nom']) . ' (' . $m['bonificacio_percentatge'] . '%)' : 'Cap' ?></td>
                    </tr>
                    <tr>
                        <th>Serveis contractats:</th>
                        <td>
                            <?php if (!empty($m['serveis'])): ?>
                                <?= implode(', ', array_map(function($s) { return esc($s['tipus']); }, $m['serveis'])) ?>
                            <?php else: ?>
                                Cap
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Observacions alumne:</th>
                        <td style="font-weight: normal; font-style: italic;">
                            <?php 
                            if (!empty($m['observacions_matricula'])) {
                                $obsM = json_decode($m['observacions_matricula'], true);
                                if (is_array($obsM)) {
                                    foreach ($obsM as $o) {
                                        echo "<div>[" . date('d/m/Y', strtotime($o['data'])) . "]: " . esc($o['text']) . "</div>";
                                    }
                                } else {
                                    echo esc($m['observacions_matricula']);
                                }
                            } else {
                                echo "—";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="section">
        <div class="section-title">Tutors legals</div>
        <?php if (!empty($tutors)): ?>
            <?php foreach ($tutors as $tutor): ?>
            <div class="tutor-row">
                <div class="tutor-nom"><?= esc($tutor->nom) ?> <?= esc($tutor->cognom1) ?> —
                    <em><?= esc($tutor->rol) ?></em>
                </div>
                <div class="tutor-info">
                    DNI: <?= !empty($tutor->dni) ? esc($tutor->dni) : '—' ?>
                    · Tel: <?= !empty($tutor->telefon) ? esc($tutor->telefon) : '—' ?>
                    · Email: <?= !empty($tutor->email) ? esc($tutor->email) : '—' ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="tutor-row">—</div>
        <?php endif; ?>
    </div>

    <div class="section">
        <div class="section-title">Observacions de l'expedient (Secretaria)</div>
        <div style="padding: 8px 12px; min-height: 40px; font-style: italic; color: #444;">
            <?php
            $historial = !empty($alumne->observacions_alumne) ? json_decode($alumne->observacions_alumne, true) : [];
            if (empty($historial)): ?>
                —
            <?php else: ?>
                <ul style="margin: 0; padding-left: 15px;">
                        <?php foreach (array_reverse($historial) as $obs): ?>
                        <li style="margin-bottom: 5px;">
                            <strong>[<?= date('d/m/Y H:i', strtotime($obs['data'])) ?>]:</strong>
                                <?= esc($obs['text']) ?>
                        </li>
                        <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        Document generat automàticament per l'Institut Caparrella · <?= date('Y') ?>
    </div>

</body>

</html>