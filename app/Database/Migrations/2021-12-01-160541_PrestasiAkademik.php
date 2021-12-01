<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PrestasiAkademik extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
            ],
            'kategori' => [
                'type' => 'ENUM("siswa", "guru", "pegawai")',
                'null' => TRUE,
            ],
            'tingkat' => [
                'type' => 'ENUM("kec", "kab", "prov", "nas", "kota", "inter", "antar_sekolah")',
                'null' => TRUE,
            ],
            'keterangan' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ]
        ]);
        
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('prestasi_akademik');
    }

    public function down()
    {
        $this->forge->dropTable('prestasi_akademik');
    }
}
