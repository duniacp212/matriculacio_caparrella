<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateAlumneTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `alumne` (
                `id_alumne`      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nom`            VARCHAR(50) NOT NULL,
                `cognom1`        VARCHAR(50) NOT NULL,
                `cognom2`        VARCHAR(50) DEFAULT NULL,
                `data_naixement` DATE NOT NULL,
                `telefon`        VARCHAR(20) DEFAULT NULL,
                `dni`            VARCHAR(20) NOT NULL,
                `direccio`       VARCHAR(100) NOT NULL,
                `email`          VARCHAR(100) DEFAULT NULL,
                `expedient`      VARCHAR(255) DEFAULT NULL,
                `codi`           VARCHAR(10) DEFAULT NULL,
                `codi_expiracio` DATETIME DEFAULT NULL,
                `estat`          VARCHAR(20) DEFAULT NULL,
                PRIMARY KEY (`id_alumne`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('alumne');
    }
}