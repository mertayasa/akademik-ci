<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PredikatKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'jenjang' => [
                'type' => 'INTEGER',
                'null' => false
            ],
            'predikat' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false
            ],
        ]); 

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('predikat_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('predikat_kelas');
    }
}
