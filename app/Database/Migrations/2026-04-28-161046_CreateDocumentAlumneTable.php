<?php

use CodeIgniter\Database\Migration;

class CreateDocumentAlumneTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_document' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_alumne' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'nom_original' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'nom_fitxer' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'ruta' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => false,
            ],
            'tipus' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'any_academic' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'creat_el' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_document', true);
        $this->forge->addForeignKey('id_alumne', 'alumne', 'id_alumne', 'CASCADE', 'CASCADE');
        $this->forge->createTable('document_alumne');
    }

    public function down()
    {
        $this->forge->dropTable('document_alumne');
    }
}