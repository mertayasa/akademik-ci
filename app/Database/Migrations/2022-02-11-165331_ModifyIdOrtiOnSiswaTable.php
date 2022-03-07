<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyIdOrtiOnSiswaTable extends Migration
{
    public function up()
    {
        // $fields = [
        //     'id_ortu' => [
        //         'type' => 'INT',
        //         'constraint' => 11,
        //         'unsigned' => TRUE,
        //         'null' => TRUE
        //     ]
        // ];

        // $this->forge->modifyColumn('siswa', $fields);
    }

    public function down()
    {
        // $fields = [
        //     'id_ortu' => [
        //         'type' => 'INT',
        //         'constraint' => 11,
        //         'unsigned' => TRUE,
        //         'null' => FALSE
        //     ]
        // ];

        // $this->forge->modifyColumn('siswa', $fields);
    }
}
