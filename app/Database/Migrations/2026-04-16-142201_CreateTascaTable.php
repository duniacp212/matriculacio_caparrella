<?php

use CodeIgniter\Database\Migration;

class CreateTascaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tasca' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'titol' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'descripcio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'data' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'creat_el' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_tasca', true);
        $this->forge->createTable('tasca');
    }

    public function down()
    {
        $this->forge->dropTable('tasca');
    }
}