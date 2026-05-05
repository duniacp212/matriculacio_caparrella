<?php
use CodeIgniter\Database\Migration;

class CreateAlumneTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alumne' => [
                'type' => 'BINARY',
                'constraint' => 16,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'cognom1' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'cognom2' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'data_naixement' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'telefon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'telefon2' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'dni' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'carrer' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'pis' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'codi_postal' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'poblacio' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'nacionalitat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'lloc_naixement' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'expedient' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'observacions' => [
                'type' => 'TEXT',
                'null' => true,
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