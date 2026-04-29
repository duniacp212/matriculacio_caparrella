<?php
use CodeIgniter\Database\Migration;

class CreateMatriculaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_matricula' => [
                'type'       => 'BINARY',
                'constraint' => 16,
            ],
            'id_alumne' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'id_estudi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_poble' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'data_pagament' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'data' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'estat' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
            ],
            'torn' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
            ],
            'observacions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_matricula', true);

        $this->forge->addForeignKey(
            'id_alumne',
            'alumne',
            'id_alumne',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_estudi',
            'estudi',
            'id_estudi',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_poble',
            'poble',
            'id_poble',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('matricula');
    }

    public function down()
    {
        $this->forge->dropTable('matricula');
    }
}
