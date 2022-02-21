<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdTahunAjarToPrestasiTable extends Migration
{
    public function up()
    {
        $fields = [
            'id_tahun_ajar' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ]
        ];
        $this->forge->addColumn('prestasi_akademik', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('prestasi_akademik', 'id_tahun_ajar');
    }
}
