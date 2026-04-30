<?php
use CodeIgniter\Database\Migration;

class CreateServeisComplementarisTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_servei' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tipus' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'estat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'preu' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id_servei', true);
        $this->forge->createTable('serveis_complementaris');
    }

    public function down()
    {
        $this->forge->dropTable('serveis_complementaris');
    }
}
