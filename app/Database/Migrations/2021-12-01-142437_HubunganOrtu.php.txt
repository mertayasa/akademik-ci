<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HubunganOrtu extends Migration
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
            'id_ortu' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_ortu','users','id', 'SET NULL','SET NULL');
        $this->forge->addForeignKey('id_siswa','users','id', 'SET NULL','SET NULL');
        $this->forge->createTable('hubungan_ortu');
    }

    public function down()
    {
        $this->forge->dropTable('hubungan_ortu');
    }
}
