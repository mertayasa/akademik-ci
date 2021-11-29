<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
                'constraint' => 50,
                'null' => TRUE
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => TRUE
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
                'null' => TRUE
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
                'null' => TRUE
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'unique' => true,
                'null' => TRUE
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
                'null' => TRUE
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'status_guru' => [
                'type' => 'ENUM("bukan_guru", "tetap", "honorer")',
                'default' => 'bukan_guru',
                'null' => FALSE,
            ],
            'level' => [
                'type' => 'ENUM("admin", "kepsek", "ortu", "siswa", "guru")',
                'default' => 'siswa',
                'null' => FALSE
            ],
            'status' => [
                'type' => 'ENUM("aktif", "nonaktif")',
                'default' => 'aktif',
                'null' => FALSE
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'alamat' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
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
        $this->forge->createTable('users', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
