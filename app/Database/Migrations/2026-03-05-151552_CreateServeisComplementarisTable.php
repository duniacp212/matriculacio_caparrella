<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServeisComplementarisTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_servei' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tipus' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'estat' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'preu' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'null'       => true,
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