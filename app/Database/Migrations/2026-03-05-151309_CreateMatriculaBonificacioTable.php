<?php
use CodeIgniter\Database\Migration;

class CreateMatriculaBonificacioTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_matricula' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_bonificacio' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'estat' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'observacions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey(['id_matricula', 'id_bonificacio'], true);

        $this->forge->addForeignKey(
            'id_matricula',
            'matricula',
            'id_matricula',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_bonificacio',
            'bonificacio',
            'id_bonificacio',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('matricula_bonificacio');
    }

    public function down()
    {
        $this->forge->dropTable('matricula_bonificacio');
    }
}
