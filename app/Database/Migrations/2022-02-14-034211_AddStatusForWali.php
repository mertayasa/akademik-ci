<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusForWali extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'ENUM("aktif", "nonaktif")',
                'default' => 'aktif',
                'null' => FALSE
            ]
        ];
        $this->forge->addColumn('wali_kelas', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('wali_kelas', 'status');
    }
}
