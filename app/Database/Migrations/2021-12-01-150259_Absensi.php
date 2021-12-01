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
            'id_jadwal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'kehadiran' => [
                'type' => 'ENUM("hadir", "tidak_hadir")',
                'default' => "tidak_hadir",
                'null' => FALSE
            ],
        ]);
        
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_anggota_kelas','anggota_kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_kelas','kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_jadwal','jadwal','id', 'RESTRICT','RESTRICT');
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
