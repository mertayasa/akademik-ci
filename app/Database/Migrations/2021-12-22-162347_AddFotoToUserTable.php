<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToUserTable extends Migration
{
    public function up()
    {
        //     $fields = [
        //         'foto' => [
        //             'type' => 'VARCHAR',
        //             'constraint' => 250,
        //             'null' => TRUE
        //         ],
        //     ];

        //     $this->forge->addColumn('', $fields);
    }

    public function down()
    {
        // $this->forge->dropColumn('users', 'foto');
    }
}
