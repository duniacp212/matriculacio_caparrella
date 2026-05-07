<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateMissatgePlantillaTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `missatge_plantilla` (
                `id_plantilla` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (`id_plantilla`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('missatge_plantilla');
    }
}