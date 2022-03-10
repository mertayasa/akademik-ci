<?php

namespace App\Database\Seeds;

use App\Models\OrtuModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Carbon\Carbon;

class OrtuSeeder extends Seeder
{
    protected $ortu;
    public function __construct()
    {
        $this->ortu = new OrtuModel;
    }
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i <= 10; $i++) {
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'nik' => '100' . rand(100, 999) . '000095600' . rand(100, 999),
                'pekerjaan' => null,
                'no_telp' => $faker->e164PhoneNumber(),
                'alamat' => $faker->address(),
                'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
                'tempat_lahir' => $faker->address(),
                'status' => 'aktif',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->ortu->updateOrInsert(['email' => $data['email']], $data);
        }

        $data = [
            'nama' => $faker->name(),
            'email' => 'ortu@demo.com',
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'nik' => '100' . rand(100, 999) . '000095600' . rand(100, 999),
            'pekerjaan' => null,
            'no_telp' => $faker->e164PhoneNumber(),
            'alamat' => $faker->address(),
            'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
            'tempat_lahir' => $faker->address(),
            'status' => 'aktif',
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];
        $this->ortu->updateOrInsert(['email' => $data['email']], $data);
    }
}
