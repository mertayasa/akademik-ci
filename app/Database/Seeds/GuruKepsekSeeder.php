<?php

namespace App\Database\Seeds;

use App\Models\GuruKepsekModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class GuruKepsekSeeder extends Seeder
{
    protected $guru_kepsek;
    public function __construct()
    {
        $this->guru_kepsek = new GuruKepsekModel;
    }
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i <= 20; $i++) {
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'level' => 'guru',
                'nip' => '100' . rand(100, 999) . '0000956' . rand(100, 999),
                'alamat' => $faker->address(),
                'no_telp' => $faker->e164PhoneNumber(),
                'status_guru' => 'tetap',
                'tempat_lahir' => $faker->address(),
                'status' => 'aktif',
                'bio' => null,
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->guru_kepsek->updateOrInsert(['email' => $data['email']], $data);
        }
        for ($i = 0; $i <= 20; $i++) {
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'level' => 'guru',
                'nip' => '100' . rand(100, 999) . '0000956' . rand(100, 999),
                'alamat' => $faker->address(),
                'no_telp' => $faker->e164PhoneNumber(),
                'status_guru' => 'honorer',
                'tempat_lahir' => $faker->address(),
                'status' => 'aktif',
                'bio' => null,
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->guru_kepsek->updateOrInsert(['email' => $data['email']], $data);
        }
        for ($i = 0; $i <= 20; $i++) {
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'level' => 'guru',
                'nip' => '100' . rand(100, 999) . '0000956' . rand(100, 999),
                'alamat' => $faker->address(),
                'no_telp' => $faker->e164PhoneNumber(),
                'status_guru' => 'bukan_guru',
                'tempat_lahir' => $faker->address(),
                'status' => 'aktif',
                'bio' => null,
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->guru_kepsek->updateOrInsert(['email' => $data['email']], $data);
        }
        $data = [
            'nama' => $faker->name(),
            'email' => $faker->email(),
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'level' => 'kepsek',
            'nip' => '100' . rand(100, 999) . '0000956' . rand(100, 999),
            'alamat' => $faker->address(),
            'no_telp' => $faker->e164PhoneNumber(),
            'status_guru' => 'tetap',
            'tempat_lahir' => $faker->address(),
            'status' => 'aktif',
            'bio' => null,
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];
        $this->guru_kepsek->updateOrInsert(['email' => $data['email']], $data);
    }
}
