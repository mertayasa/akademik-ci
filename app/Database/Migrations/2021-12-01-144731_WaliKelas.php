<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WaliKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'id_tahun_ajar' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'id_guru_wali' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
        ]);
        
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_kelas','kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_tahun_ajar','tahun_ajar','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_guru_wali','users','id', 'RESTRICT','RESTRICT');
        $this->forge->createTable('wali_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('wali_kelas');
    }
}
