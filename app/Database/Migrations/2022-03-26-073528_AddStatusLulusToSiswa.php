<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusLulusToSiswa extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'ENUM("aktif", "nonaktif", "lulus")',
                'default' => 'aktif',
                'null' => FALSE
            ],
        ];

        $this->forge->modifyColumn('siswa', $fields);
    }

    public function down()
    {
        //
    }
}
