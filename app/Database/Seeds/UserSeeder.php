<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $level = ["admin", "kepsek", "ortu", "siswa"];

        for($i=0; $i<=100; $i++){
            $data = [
                'nama' => $faker->name(),
                'email'    => $faker->email(),
                'password'    => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'level'    => $level[rand(0,3)],
            ];
    
            $this->db->table('users')->insert($data);
        }
    }
}