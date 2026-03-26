<?php
use CodeIgniter\Database\Migration;

class CreateAssignaturaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_assignatura' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_estudi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'estat' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
        ]);


        $this->forge->addKey('id_assignatura', true);


        $this->forge->addForeignKey(
            'id_estudi',
            'estudi',
            'id_estudi',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('assignatura');
    }

    public function down()
    {
        $this->forge->dropTable('assignatura');
    }
}
