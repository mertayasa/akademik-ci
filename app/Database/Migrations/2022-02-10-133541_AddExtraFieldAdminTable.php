<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExtraFieldAdminTable extends Migration
{
    public function up()
    {
        $field = [
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 18,
                'unique' => TRUE,
                'null' => TRUE,
            ],
            'alamat' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'unique' => true,
                'null' => TRUE,
            ],
        ];
        $this->forge->addColumn('admin', $field);
    }

    public function down()
    {
        $this->forge->dropColumn('admin', 'nip');
        $this->forge->dropColumn('admin', 'alamat');
        $this->forge->dropColumn('admin', 'no_telp');
    }
}
