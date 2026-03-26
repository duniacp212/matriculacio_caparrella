<?php

use CodeIgniter\Database\Migration;

class CreateFamiliaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_familia' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ]
        ]);

        $this->forge->addKey('id_familia', true);
        $this->forge->createTable('familia');
    }

    public function down()
    {
        $this->forge->dropTable('familia');
    }
}
