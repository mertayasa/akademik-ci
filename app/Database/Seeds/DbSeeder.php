<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DbSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('TahunAjarSeeder');
        $this->call('KelasSeeder');
        $this->call('WaliKelasSeeder');
        $this->call('AnggotaKelasSeeder');
        $this->call('MapelSeeder');
        $this->call('JadwalSeeder');
    }
}
