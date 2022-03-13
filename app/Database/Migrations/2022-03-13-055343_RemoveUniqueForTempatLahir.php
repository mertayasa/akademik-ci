<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveUniqueForTempatLahir extends Migration
{
    public function up()
    {
        $fields = [
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => FALSE,
                'null' => TRUE
            ],
        ];

        $this->forge->modifyColumn('ortu', $fields);
        $this->forge->modifyColumn('siswa', $fields);
        $this->forge->modifyColumn('guru_kepsek', $fields);
    }

    public function down()
    {
        //
    }
}
