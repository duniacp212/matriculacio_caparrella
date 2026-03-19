<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateMatriculaTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `matricula` (
                `id_matricula`  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_alumne`     INT(11) UNSIGNED NOT NULL,
                `id_estudi`     INT(11) UNSIGNED NOT NULL,
                `id_poble`      INT(11) UNSIGNED DEFAULT NULL,
                `data_pagament` DATE DEFAULT NULL,
                `data`          DATE NOT NULL,
                `estat`         VARCHAR(30) NOT NULL,
                `torn`          INT(2) NOT NULL,
                `observacions`  TEXT DEFAULT NULL,
                PRIMARY KEY (`id_matricula`),
                KEY `matricula_id_alumne_foreign` (`id_alumne`),
                KEY `matricula_id_estudi_foreign` (`id_estudi`),
                KEY `matricula_id_poble_foreign`  (`id_poble`),
                CONSTRAINT `matricula_id_alumne_foreign` FOREIGN KEY (`id_alumne`) REFERENCES `alumne` (`id_alumne`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `matricula_id_estudi_foreign` FOREIGN KEY (`id_estudi`) REFERENCES `estudi` (`id_estudi`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `matricula_id_poble_foreign`  FOREIGN KEY (`id_poble`)  REFERENCES `poble`  (`id_poble`)  ON DELETE SET NULL ON UPDATE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('matricula');
    }
}