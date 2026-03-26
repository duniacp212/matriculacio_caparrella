<?php
use CodeIgniter\Database\Migration;

class CreateMissatgeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_missatge' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_matricula' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'data' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'asumpte' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_missatge', true);

        $this->forge->addForeignKey(
            'id_matricula',
            'matricula',
            'id_matricula',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('missatge');
    }

    public function down()
    {
        $this->forge->dropTable('missatge');
    }
}
