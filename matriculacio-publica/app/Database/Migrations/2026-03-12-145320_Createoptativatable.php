<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateOptativaTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `optativa` (
                `id_optativa` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_estudi`   INT(11) UNSIGNED NOT NULL,
                `nom`         VARCHAR(50) NOT NULL,
                `estat`       VARCHAR(20) NOT NULL DEFAULT "actiu",
                PRIMARY KEY (`id_optativa`),
                KEY `optativa_id_estudi_foreign` (`id_estudi`),
                CONSTRAINT `optativa_id_estudi_foreign` FOREIGN KEY (`id_estudi`) REFERENCES `estudi` (`id_estudi`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('optativa');
    }
}