<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateEstudiTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `estudi` (
                `id_estudi`  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_familia` INT(11) UNSIGNED NOT NULL,
                `tipus`      VARCHAR(100) NOT NULL,
                `nivell`     VARCHAR(20) NOT NULL,
                `estat`      VARCHAR(20) NOT NULL DEFAULT "actiu",
                PRIMARY KEY (`id_estudi`),
                KEY `estudi_id_familia_foreign` (`id_familia`),
                CONSTRAINT `estudi_id_familia_foreign` FOREIGN KEY (`id_familia`) REFERENCES `familia` (`id_familia`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('estudi');
    }
}