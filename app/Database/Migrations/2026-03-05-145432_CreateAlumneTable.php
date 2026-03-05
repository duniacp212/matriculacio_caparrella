<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlumneTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alumne' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'cognom1' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'cognom2' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'data_naixement' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'telefon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'dni' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'direccio' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'expedient' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_alumne', true);
        $this->forge->createTable('alumne');
    }

    public function down()
    {
        $this->forge->dropTable('alumne');
    }
}