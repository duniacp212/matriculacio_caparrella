<?php
use CodeIgniter\Database\Migration;

class CreateAlumneTutorLegalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tutor' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
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
            'telefon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'dni' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'rol' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'id_alumne' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id_tutor', true);

        $this->forge->addForeignKey(
            'id_alumne',
            'alumne',
            'id_alumne',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('alumne_tutor_legal');
    }

    public function down()
    {
        $this->forge->dropTable('alumne_tutor_legal');
    }
}
