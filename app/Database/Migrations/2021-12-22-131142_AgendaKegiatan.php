<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgendaKegiatan extends Migration
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
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'status' => [
                'type' => 'ENUM("aktif", "nonaktif")',
                'default' => 'aktif',
                'null' => FALSE,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('agenda_kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('agenda_kegiatan');
    }
}
