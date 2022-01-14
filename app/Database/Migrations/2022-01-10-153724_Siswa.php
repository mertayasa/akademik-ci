<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 18,
                'unique' => TRUE,
            ],
            'id_ortu' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
                'null' => TRUE
            ],
            'angkatan' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'status' => [
                'type' => 'ENUM("aktif", "nonaktif")',
                'default' => 'aktif',
                'null' => FALSE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_ortu', 'ortu', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('siswa', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}
