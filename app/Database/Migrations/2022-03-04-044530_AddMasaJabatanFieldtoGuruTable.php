<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMasaJabatanFieldtoGuruTable extends Migration
{
    public function up()
    {
        $fields = [
            'masa_jabatan_kepsek' => [
                'type' => 'VARCHAR',
                'constraint' => 12,
                'null' => TRUE
            ]
        ];
        $this->forge->addColumn('guru_kepsek', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('guru_kepsek', 'masa_jabatan_kepsek');
    }
}
