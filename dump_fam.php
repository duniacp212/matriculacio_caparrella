<?php
require 'public/index.php';
$db = \Config\Database::connect();
$estudis = $db->table('estudi e')->select('e.id_estudi, e.tipus, e.nivell, e.matricula_viva, f.nom as familia')->join('familia f', 'e.id_familia = f.id_familia', 'left')->get()->getResultArray();
echo json_encode($estudis, JSON_PRETTY_PRINT);
