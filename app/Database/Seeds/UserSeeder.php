<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $level = ["admin", "kepsek", "ortu", "siswa", "guru"];

        for($i=0; $i<=100; $i++){
            $data = [
                'nama' => $faker->name(),
                'email'    => $faker->email(),
                'password'    => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'level'    => $level[rand(0,4)],
                'created_at'    => Time::now(),
                'updated_at'    => Time::now(),
            ];
    
            $this->db->table('users')->insert($data);
        }
    }
}