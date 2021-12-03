<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use Carbon\Carbon;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{

    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $level = ["admin", "kepsek", "ortu", "siswa", "guru"];
        $status_guru = ["bukan_guru", "honorer", "tetap"];

        for($i=0; $i<=31; $i++){
            if($i == 0){
                $selected_level = $level[0];
            }
            $selected_level = $level[rand(0,4)];
            
            $data = [
                'nama' => $faker->name(),
                'email' => $i == 0 ? 'admin@demo.com' : $faker->email(),
                'nis' => $selected_level == 'siswa' ? '1000000000123'.rand(100, 999) : null,
                'nip' => $selected_level == 'guru' ? '1000000000956'.rand(100, 999) : null,
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
            
            $this->user->updateOrInsert(['email', $data['email']], $data);
            // $this->db->table('users')->insert($data);
        }
    }
}