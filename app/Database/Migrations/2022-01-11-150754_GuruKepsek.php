<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GuruKepsek extends Migration
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
            'level' => [
                'type' => 'ENUM("kepsek", "guru")',
                'default' => 'guru',
                'null' => FALSE
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 18,
                'unique' => TRUE,
                'null' => TRUE,
            ],
            'alamat' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'unique' => true,
                'null' => TRUE,
            ],
            'status_guru' => [
                'type' => 'ENUM("tetap","honorer", "bukan_guru")',
                'default' => 'tetap',
                'null' => FALSE
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
                'null' => TRUE
            ],
            'status' => [
                'type' => 'ENUM("aktif", "nonaktif")',
                'default' => 'aktif',
                'null' => FALSE
            ],
            'bio' => [
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
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('guru_kepsek', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('guru_kepsek');
    }
}
