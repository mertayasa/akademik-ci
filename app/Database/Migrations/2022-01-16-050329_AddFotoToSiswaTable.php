<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToSiswaTable extends Migration
{
    public function up()
    {
        $fields = [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => TRUE
            ],
        ];

        $this->forge->addColumn('siswa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('siswa', 'foto');
    }
}
