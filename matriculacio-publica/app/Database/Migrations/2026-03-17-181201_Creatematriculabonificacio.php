<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateMatriculaBonificacioTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `matricula_bonificacio` (
                `id_matricula`   INT(11) UNSIGNED NOT NULL,
                `id_bonificacio` INT(11) UNSIGNED NOT NULL,
                `estat`          VARCHAR(50) DEFAULT NULL,
                `observacions`   TEXT DEFAULT NULL,
                PRIMARY KEY (`id_matricula`, `id_bonificacio`),
                KEY `matricula_bonificacio_id_bonificacio_foreign` (`id_bonificacio`),
                CONSTRAINT `matricula_bonificacio_id_matricula_foreign`   FOREIGN KEY (`id_matricula`)   REFERENCES `matricula`   (`id_matricula`)   ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `matricula_bonificacio_id_bonificacio_foreign` FOREIGN KEY (`id_bonificacio`) REFERENCES `bonificacio` (`id_bonificacio`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('matricula_bonificacio');
    }
}