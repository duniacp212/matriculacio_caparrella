<?php
use CodeIgniter\Database\Migration;

class AddFieldsToSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('settings', [
            'clau' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'valor' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('settings', ['clau', 'valor']);
    }
}

