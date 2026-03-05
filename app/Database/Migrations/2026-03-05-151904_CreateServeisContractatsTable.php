<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServeisContractatsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_servei' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_matricula' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'data_alta' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey(['id_servei', 'id_matricula'], true);

        $this->forge->addForeignKey(
            'id_servei',
            'serveis_complementaris',
            'id_servei',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_matricula',
            'matricula',
            'id_matricula',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('serveis_contractats');
    }

    public function down()
    {
        $this->forge->dropTable('serveis_contractats');
    }
}