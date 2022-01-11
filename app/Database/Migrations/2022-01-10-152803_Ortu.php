<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ortu extends Migration
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
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 18,
                'unique' => TRUE,
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'unique' => true,
                'null' => TRUE,
            ],
            'alamat' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
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
        $this->forge->createTable('ortu', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('ortu');
    }
}
