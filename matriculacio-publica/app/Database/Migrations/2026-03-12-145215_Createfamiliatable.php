<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateFamiliaTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `familia` (
                `id_familia` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nom`        VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id_familia`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('familia');
    }
}