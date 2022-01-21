<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHarianToNilaiTable extends Migration
{
    public function up()
    {
        $field = [
            'harian' => [
                'type' => 'double',
                'null' => true
            ]
        ];
        $this->forge->addColumn('nilai', $field);
    }

    public function down()
    {
        $this->forge->dropColumn('nilai', 'harian');
    }
}
