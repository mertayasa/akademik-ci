<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyMasaJabatanKepsek extends Migration
{
    public function up()
    {
        $fields = [
            'masa_jabatan_kepsek' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ]
        ];

        $this->forge->modifyColumn('guru_kepsek', $fields);
    }

    public function down()
    {
        $fields = [
            'masa_jabatan_kepsek' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ]
        ];

        $this->forge->modifyColumn('guru_kepsek', $fields);
    }
}
