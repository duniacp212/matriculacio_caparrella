<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateAlumneTutorLegalTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `alumne_tutor_legal` (
                `id_tutor`             INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nom`                  VARCHAR(50) NOT NULL,
                `cognom1`              VARCHAR(50) NOT NULL,
                `cognom2`              VARCHAR(50) DEFAULT NULL,
                `telefon`              VARCHAR(20) NOT NULL,
                `email`                VARCHAR(100) NOT NULL,
                `dni`                  VARCHAR(50) NOT NULL,
                `rol`                  VARCHAR(50) NOT NULL,
                `custodia_percentatge` INT(3) NOT NULL,
                `id_alumne`            INT(11) UNSIGNED NOT NULL,
                PRIMARY KEY (`id_tutor`),
                KEY `alumne_tutor_legal_id_alumne_foreign` (`id_alumne`),
                CONSTRAINT `alumne_tutor_legal_id_alumne_foreign` FOREIGN KEY (`id_alumne`) REFERENCES `alumne` (`id_alumne`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('alumne_tutor_legal');
    }
}