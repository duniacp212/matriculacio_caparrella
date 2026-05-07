<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class Createpobletable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `poble` (
                `id_poble` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nom`      VARCHAR(100) NOT NULL,
                PRIMARY KEY (`id_poble`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('poble');
    }
}