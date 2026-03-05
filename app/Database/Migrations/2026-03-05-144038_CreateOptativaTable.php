<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOptativaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_optativa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_estudi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'estat' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'actiu',
            ],
        ]);

        $this->forge->addKey('id_optativa', true);

        $this->forge->addForeignKey(
            'id_estudi',
            'estudi',
            'id_estudi',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('optativa');
    }

    public function down()
    {
        $this->forge->dropTable('optativa');
    }
}