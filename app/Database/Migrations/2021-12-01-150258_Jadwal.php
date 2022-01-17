<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jadwal extends Migration
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
            'id_guru' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'id_mapel' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'jam_mulai' => [
                'type' => 'TIME',
                'null' => FALSE
            ],
            'jam_selesai' => [
                'type' => 'TIME',
                'null' => FALSE
            ],
            'kode_hari' => [
                'type' => 'INT',
                'null' => FALSE
            ],
            'hari' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE
            ],
            'id_tahun_ajar' => [
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
        $this->forge->addForeignKey('id_tahun_ajar', 'tahun_ajar', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_kelas', 'kelas', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_mapel', 'mapel', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_guru', 'guru_kepsek', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
