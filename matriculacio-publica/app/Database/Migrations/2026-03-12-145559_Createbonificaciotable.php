<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateBonificacioTable extends Migration
{
    public function up(): void
    {
        $this->db->query('
            CREATE TABLE `bonificacio` (
                id_bonificacio INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(255) NOT NULL,
                requereix_document TINYINT(1) NOT NULL,
                percentatge DECIMAL(5,2) NOT NULL,
                descripcio TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');
    }

    public function down(): void
    {
        $this->forge->dropTable('bonificacio');
    }
}