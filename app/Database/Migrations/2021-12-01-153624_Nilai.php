<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nilai extends Migration
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
            'id_jadwal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'id_anggota_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'tugas' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'uts' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'uas' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
        ]);
        
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_kelas','kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_jadwal','jadwal','id', 'RESTRICT','RESTRICT');
        $this->forge->addForeignKey('id_anggota_kelas','anggota_kelas','id', 'RESTRICT','RESTRICT');
        $this->forge->createTable('nilai');
    }

    public function down()
    {
        $this->forge->dropTable('nilai');
    }
}
