<?php

namespace App\Database\Seeds;

use Carbon\Carbon;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $level = ["admin", "kepsek", "ortu", "siswa", "guru"];
        $status_guru = ["bukan_guru", "honorer", "tetap"];

        for($i=0; $i<=100; $i++){
            $selected_level = $level[rand(0,4)];
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'nis' => $selected_level == 'siswa' ? '1000000000424'.rand(001, 450) : null,
                'nip' => $selected_level == 'guru' ? '1000000000423'.rand(001, 450) : null,
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
                'tempat_lahir' => $faker->address(),
                'status_guru' => $selected_level == 'guru' ? $status_guru[rand(1,2)] : 'bukan_guru',
                'pekerjaan' => $selected_level == 'ortu' ? $faker->jobTitle() : null,
                'no_telp' => $faker->e164PhoneNumber(),
                'alamat' => $faker->address(),
                'status' => 'active',
                'level' => $selected_level,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
    
            $this->db->table('users')->insert($data);
        }
    }
}