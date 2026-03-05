<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBonificacioTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bonificacio' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tipus' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'descripcio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'percentatge' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id_bonificacio', true);
        $this->forge->createTable('bonificacio');
    }

    public function down()
    {
        $this->forge->dropTable('bonificacio');
    }
}