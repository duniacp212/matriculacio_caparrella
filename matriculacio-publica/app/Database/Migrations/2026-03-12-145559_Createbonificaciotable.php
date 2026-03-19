<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateBonificacioTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `bonificacio` (
                `id_bonificacio` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `tipus`          VARCHAR(100) NOT NULL,
                `descripcio`     TEXT DEFAULT NULL,
                `percentatge`    INT(3) NOT NULL,
                PRIMARY KEY (`id_bonificacio`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('bonificacio');
    }
}