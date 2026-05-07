<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `settings` (
                `id_settings` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (`id_settings`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('settings');
    }
}