<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_settings' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ]);

        $this->forge->addKey('id_settings', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}