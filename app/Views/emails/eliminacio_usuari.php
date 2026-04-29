<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Compte d'usuari eliminat</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 5px;">
        <h2 style="color: #ef4444;">Avís d'eliminació de compte</h2>
        <p>Hola <?= esc($nom) ?>,</p>
        <p>T'informem que el teu compte d'usuari (<strong><?= esc($usuari) ?></strong>) a la plataforma de l'Institut Caparrella ha estat eliminat per un administrador.</p>
        <p>Si creus que això és un error, si us plau posa't en contacte amb el departament d'informàtica o secretaria.</p>
        
        <p style="font-size: 0.9em; color: #666; margin-top: 30px;">
            Això és un missatge automàtic, si us plau no responguis a aquest correu.
        </p>
    </div>
</body>
</html>
