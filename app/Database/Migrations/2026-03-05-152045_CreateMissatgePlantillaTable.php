<?php
use CodeIgniter\Database\Migration;

class CreateMissatgePlantillaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_plantilla' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ]);

        $this->forge->addKey('id_plantilla', true);
        $this->forge->createTable('missatge_plantilla');
    }

    public function down()
    {
        $this->forge->dropTable('missatge_plantilla');
    }
}
