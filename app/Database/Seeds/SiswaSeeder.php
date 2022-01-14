<?php

namespace App\Database\Seeds;

use App\Models\OrtuModel;
use App\Models\SiswaModel;
use CodeIgniter\Database\Seeder;
use Carbon\Carbon;
use CodeIgniter\I18n\Time;

class SiswaSeeder extends Seeder
{
    protected $siswa;
    protected $ortu;
    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->ortu = new OrtuModel;
    }
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $ortu = $this->ortu->orderBy('id', 'RANDOM')->findAll();
        foreach ($ortu as $val) {
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'nis' => '006' . rand(100, 999) . '0956' . rand(100, 999),
                'id_ortu' => $val['id'],
                'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
                'tempat_lahir' => $faker->address(),
                'angkatan' => $faker->year(),
                'status' => 'aktif',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->siswa->updateOrInsert(['email' => $data['email']], $data);
        }

        $data = [
            'nama' => $faker->name(),
            'email' => 'siswa@demo.com',
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'nis' => '006' . rand(100, 999) . '0956' . rand(100, 999),
            'id_ortu' => $val['id'],
            'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('Y-m-d'), Carbon::now()->subYears(10)->format('Y-m-d'))->format('Y-m-d'),
            'tempat_lahir' => $faker->address(),
            'angkatan' => $faker->year(),
            'status' => 'aktif',
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];
        $this->siswa->updateOrInsert(['email' => $data['email']], $data);
    }
}
