<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToAdminTable extends Migration
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

        $this->forge->addColumn('admin', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('admin', 'foto');
    }
}
