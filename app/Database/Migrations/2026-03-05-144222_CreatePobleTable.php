<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePobleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_poble' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id_poble', true);
        $this->forge->createTable('poble');
    }

    public function down()
    {
        $this->forge->dropTable('poble');
    }
}