<?php
$pdo = new PDO('mysql:host=localhost;dbname=matriculacio_caparrella;charset=utf8', 'root', '');
$stmt = $pdo->query("SELECT * FROM optativa");
$opts = $stmt->fetchAll(PDO::FETCH_ASSOC);
file_put_contents('opts_out.json', json_encode($opts, JSON_PRETTY_PRINT));
