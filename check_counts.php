<?php
$db = new PDO('mysql:host=localhost;dbname=matriculacio_caparrella;charset=utf8', 'root', '');
echo "Assignatura: " . count($db->query('SELECT * FROM assignatura')->fetchAll()) . "\n";
echo "Optativa: " . count($db->query('SELECT * FROM optativa')->fetchAll()) . "\n";
