<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBioToUserTable extends Migration
{
    public function up()
    {
        // $fields = [
        //     'bio' => [
        //         'type' => 'LONGTEXT',
        //         'null' => TRUE
        //     ]
        // ];

        // $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        // $this->forge->dropColumn('users', 'bio');
    }
}
