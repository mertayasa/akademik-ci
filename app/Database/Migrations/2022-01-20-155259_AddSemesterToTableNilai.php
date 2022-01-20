<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSemesterToTableNilai extends Migration
{
    public function up()
    {
        $field = [
            'semester' => [
                'type' => 'ENUM("ganjil", "genap")',
                'default' => 'ganjil',
                'null' => TRUE,
            ],

        ];
        $this->forge->addColumn('nilai', $field);
    }

    public function down()
    {
        $this->forge->dropColumn('nilai', 'semester');
    }
}
