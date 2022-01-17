<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoTooOrtuTable extends Migration
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

        $this->forge->addColumn('ortu', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('ortu', 'foto');
    }
}
