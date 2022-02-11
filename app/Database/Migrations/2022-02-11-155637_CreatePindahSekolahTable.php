<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePindahSekolahTable extends Migration
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
            'id_siswa' => [
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
            'tipe' => [
                'type' => 'ENUM("masuk", "keluar")',
                'default' => 'masuk',
                'null' => FALSE,
            ],
            'asal' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
            'tujuan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
            'alasan' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_tahun_ajar', 'tahun_ajar', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('pindah_sekolah');
    }

    public function down()
    {
        $this->forge->dropTable('pindah_sekolah');
    }
}
