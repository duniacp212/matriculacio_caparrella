<?php
use CodeIgniter\Database\Migration;

class CreateEstudiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_estudi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_familia' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'tipus' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'nivell' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'estat' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'actiu',
            ],
            'matricula_viva' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'places' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => null,
            ],
        ]);

        $this->forge->addKey('id_estudi', true);

        $this->forge->addForeignKey(
            'id_familia',
            'familia',
            'id_familia',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('estudi');
    }

    public function down()
    {
        $this->forge->dropTable('estudi');
    }
}