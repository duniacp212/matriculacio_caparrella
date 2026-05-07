<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateServeisComplementarisTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `serveis_complementaris` (
                `id_servei` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `tipus`     VARCHAR(100) DEFAULT NULL,
                `estat`     VARCHAR(50) DEFAULT NULL,
                `preu`      DECIMAL(8,2) DEFAULT NULL,
                PRIMARY KEY (`id_servei`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('serveis_complementaris');
    }
}