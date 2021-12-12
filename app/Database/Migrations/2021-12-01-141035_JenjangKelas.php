<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenjangKelas extends Migration
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
            'kode' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false
            ],
        ]); 

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('jenjang_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('jenjang_kelas');
    }
}
