<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFuckingTitleToAgenda extends Migration
{
    public function up()
    {
        $field = [
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ]
        ];
        $this->forge->addColumn('agenda_kegiatan', $field);
    }

    public function down()
    {
        $this->forge->dropColumn('agenda_kegiatan', 'judul');
    }
}
