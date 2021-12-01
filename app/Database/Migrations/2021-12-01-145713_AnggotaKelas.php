<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnggotaKelas extends Migration
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
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'ENUM("aktif", "nonaktif")',
                'default' => 'aktif',
                'null' => FALSE,
            ],
        ]);
        
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_siswa','users','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_kelas','kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->createTable('anggota_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('anggota_kelas');
    }
}
