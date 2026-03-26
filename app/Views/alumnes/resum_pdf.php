<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Resum d’alumnes matriculats</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 11px; 
            color: #333; 
        }
        .header { 
            border-bottom: 2px solid #6f42c1; 
            margin-bottom: 20px; 
            padding-bottom: 10px;
        }
        .titol-header {
            font-size: 18px;
            color: #6f42c1;
            font-weight: bold;
            margin: 0;
        }
        .seccio-estudi {
            background-color: #6f42c1;
            color: white;
            padding: 8px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left;
            width: 33.33%;
            word-wrap: break-word;
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: bold;
        }
        .text-end { 
            text-align: right; 
        }
        .total-general {
            margin-top: 30px;
            text-align: right;
            border-top: 1px solid #6f42c1;
            padding-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="titol-header">Resum de Matriculació</h1>
        <p>Curs acadèmic: <?= esc($anySeleccionat ?: 'Tots') ?></p>
        <p>Data de generació: <?= date('d/m/Y H:i') ?></p>
    </div>

    <?php foreach ($dades as $estudi => $files): ?>
        <div class="seccio-estudi"><?= esc($estudi) ?></div>
        <table>
            <thead>
                <tr>
                    <th>Cicle</th>
                    <th>Curs</th>
                    <th class="text-end">Matriculats</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $fila): ?>
                    <tr>
                        <td><?= esc($fila['cicle'] ?? '—') ?></td>
                        <td><?= esc($fila['curs']) ?></td>
                        <td class="text-end"><?= esc($fila['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

    <div class="total-general">
        <strong>Total alumnes matriculats:</strong> <?= esc($totalGeneral) ?>
    </div>

</body>
</html>
