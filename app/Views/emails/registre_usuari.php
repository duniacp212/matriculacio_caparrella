<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Benvingut/da a la plataforma</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 5px;">
        <h2 style="color: #6366f1;">Benvingut/da, <?= esc($nom) ?>!</h2>
        <p>T'informem que s'ha creat correctament el teu compte d'usuari administratiu a la plataforma de matriculació de l'Institut Caparrella.</p>
        
        <div style="background-color: #f9fafb; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0;"><strong>Les teves dades d'accés:</strong></p>
            <ul style="list-style: none; padding: 0;">
                <li>Usuari: <?= esc($usuari) ?></li>
                <li>Rol: <?= esc($rol) ?></li>
            </ul>
        </div>

        <p>Pots accedir a la plataforma des del següent enllaç:</p>
        <p><a href="<?= base_url() ?>" style="display: inline-block; padding: 10px 20px; background-color: #6366f1; color: #fff; text-decoration: none; border-radius: 5px;">Accedir a la plataforma</a></p>

        <p style="font-size: 0.9em; color: #666; margin-top: 30px;">
            Això és un missatge automàtic, si us plau no responguis a aquest correu.
        </p>
    </div>
</body>
</html>
