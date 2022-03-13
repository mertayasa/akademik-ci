<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeNullableEmailSiswa extends Migration
{
    public function up()
    {
        $fields = [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => false,
                'null' => TRUE
            ]
        ];

        $this->forge->modifyColumn('siswa', $fields);
    }

    public function down()
    {
        $fields = [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => false,
                'null' => TRUE
            ]
        ];

        $this->forge->modifyColumn('siswa', $fields);
    }
}
