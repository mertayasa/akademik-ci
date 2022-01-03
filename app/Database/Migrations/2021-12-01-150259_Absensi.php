<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absensi extends Migration
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
            'id_anggota_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'kehadiran' => [
                'type' => 'ENUM("hadir", "sakit", "ijin", "tanpa_keterangan")',
                'default' => "hadir",
                'null' => FALSE
            ],
            'semester' => [
                'type' => 'ENUM("ganjil", "genap")',
                'default' => "ganjil",
                'null' => FALSE
            ],
        ]);
        
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_anggota_kelas','anggota_kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_kelas','kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
