<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TahunAjar extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'tahun_mulai' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
            ],
            'tahun_start' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('tahun_ajar', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tahun_ajar');
    }
}