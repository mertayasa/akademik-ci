<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeNikOrtuTable extends Migration
{
    public function up()
    {
        $fields = [
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 18,
                'unique' => FALSE,
                'null' => TRUE
            ]
        ];

        $this->forge->modifyColumn('ortu', $fields);
    }

    public function down()
    {
        //
    }
}
