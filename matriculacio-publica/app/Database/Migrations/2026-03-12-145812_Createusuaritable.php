<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateUsuariTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `usuari` (
                `id_usuari`  INT(11) NOT NULL AUTO_INCREMENT,
                `usuari`     VARCHAR(50) NOT NULL,
                `password`   VARCHAR(255) NOT NULL,
                `rol`        VARCHAR(20) NOT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id_usuari`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('usuari');
    }
}