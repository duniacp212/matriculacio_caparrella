<?php

use CodeIgniter\Database\Migration;

class CreateUsuariTableFinal extends Migration
{
    public function up()
    {
        $this->forge->dropTable('usuari', true);

        $this->forge->addField([
            'id_usuari' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cognom1' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cognom2' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'dni_nie' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'usuari' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'rol' => [
                'type'       => 'ENUM',
                'constraint' => ['super admin', 'administracio', 'secretaria'],
                'default'    => 'secretaria',
            ],
            'creat_el' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'actualitzat_el' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_usuari', true);
        $this->forge->createTable('usuari');
    }

    public function down()
    {
        $this->forge->dropTable('usuari');
    }
}
