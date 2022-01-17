<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToGuruKepsekTable extends Migration
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

        $this->forge->addColumn('guru_kepsek', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('guru_kepsek', 'foto');
    }
}
