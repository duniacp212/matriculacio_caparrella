<?php
/**
 * @var array $alumne
 * @var string $motiu
 * @var string $missatge
 */
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Missatge de l'Institut</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .caixa { border: 1px solid #C7CDF1; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; background-color: #EEF0FB; }
        .capcalera { color: #6D78D0; border-bottom: 2px solid #6D78D0; padding-bottom: 10px; margin-bottom: 20px; }
        .motiu { font-weight: bold; color: #15C67E; }
    </style>
</head>
<body>
    <div class="caixa">
        <h2 class="capcalera">Nou missatge de l'Institut La Caparrella</h2>
        
        <p>Hola <strong><?= esc($alumne->nom) ?> <?= esc($alumne->cognom1) ?></strong>,</p>
        
        <p>Ens posem en contacte amb tu pel següent motiu: <span class="motiu"><?= esc($motiu) ?></span></p>
        
        <p><strong>Missatge:</strong></p>
        <div style="background-color: white; padding: 15px; border-radius: 5px; border: 1px solid #ddd;">
            <?= nl2br(esc($missatge)) ?>
        </div>
        
        <p>Pots respondre a aquest correu o trucar a la secretaria del centre per a qualsevol dubte: <strong>973 288 180</strong> o <strong>973 980 350</strong>.</p>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #ccc;">
        <p style="font-size: 0.85em; color: #777;">Aquest és un correu generat automàticament des del sistema de matriculacions.</p>
    </div>
</body>
</html>
