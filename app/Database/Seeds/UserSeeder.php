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

        for($i=0; $i<=20; $i++){            
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'nis' => null,
                'nip' => '100'.rand(100, 999).'0000956'.rand(100, 999),
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
                'tempat_lahir' => $faker->address(),
                'status_guru' => $status_guru[rand(1,2)],
                'pekerjaan' => null,
                'no_telp' => $faker->e164PhoneNumber(),
                'alamat' => $faker->address(),
                'status' => 'aktif',
                'level' => 'guru',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            
            $this->user->updateOrInsert(['email' => $data['email']], $data);
        }

        for($i=0; $i<=50; $i++){            
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'nis' => '100'.rand(100, 999).'0000956'.rand(100, 999),
                'nip' => null,
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
                'tempat_lahir' => $faker->address(),
                'status_guru' => 'bukan_guru',
                'pekerjaan' => null,
                'no_telp' => $faker->e164PhoneNumber(),
                'alamat' => $faker->address(),
                'status' => 'aktif',
                'level' => 'siswa',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            
            $this->user->updateOrInsert(['email' => $data['email']], $data);
        }

        for($i=0; $i<=10; $i++){            
            $data = [
                'nama' => $faker->name(),
                'email' => $faker->email(),
                'nis' => null,
                'nip' => null,
                'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
                'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
                'tempat_lahir' => $faker->address(),
                'status_guru' => 'bukan_guru',
                'pekerjaan' => $faker->jobTitle(),
                'no_telp' => $faker->e164PhoneNumber(),
                'alamat' => $faker->address(),
                'status' => 'aktif',
                'level' => 'ortu',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            
            $this->user->updateOrInsert(['email' => $data['email']], $data);
        }

        $siswa = [
            'nama' => $faker->name(),
            'email' => 'siswa@demo.com',
            'nip' => null,
            'nis' => '100'.rand(100, 999).'0000956'.rand(100, 999),
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
            'tempat_lahir' => $faker->address(),
            'status_guru' => 'bukan_guru',
            'pekerjaan' => null,
            'no_telp' => $faker->e164PhoneNumber(),
            'alamat' => $faker->address(),
            'status' => 'aktif',
            'level' => 'siswa',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];
        
        $this->user->updateOrInsert(['email' => $siswa['email']], $siswa);

        $guru = [
            'nama' => $faker->name(),
            'email' => 'guru@demo.com',
            'nis' => null,
            'nip' => '100'.rand(100, 999).'0000956'.rand(100, 999),
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
            'tempat_lahir' => $faker->address(),
            'status_guru' => $status_guru[rand(1,2)],
            'pekerjaan' => null,
            'no_telp' => $faker->e164PhoneNumber(),
            'alamat' => $faker->address(),
            'status' => 'aktif',
            'level' => 'guru',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];
        
        $this->user->updateOrInsert(['email' => $guru['email']], $guru);
         
        $admin = [
            'nama' => $faker->name(),
            'email' => 'admin@demo.com',
            'nis' => null,
            'nip' => null,
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
            'tempat_lahir' => $faker->address(),
            'status_guru' => 'bukan_guru',
            'pekerjaan' => null,
            'no_telp' => $faker->e164PhoneNumber(),
            'alamat' => $faker->address(),
            'status' => 'aktif',
            'level' => 'admin',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];
        
        $this->user->updateOrInsert(['email' => $admin['email']], $admin);
        
        $kepsek = [
            'nama' => $faker->name(),
            'email' => 'kepsek@demo.com',
            'nis' => null,
            'nip' => null,
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
            'tempat_lahir' => $faker->address(),
            'status_guru' => 'bukan_guru',
            'pekerjaan' => null,
            'no_telp' => $faker->e164PhoneNumber(),
            'alamat' => $faker->address(),
            'status' => 'aktif',
            'level' => 'kepsek',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];
        
        $this->user->updateOrInsert(['email' => $kepsek['email']], $kepsek);

        // for($i=0; $i<=100; $i++){
        //     if($i == 0){
        //         $selected_level = $level[0];
        //     }
        //     $selected_level = $level[rand(0,4)];
            
        //     $data = [
        //         'nama' => $faker->name(),
        //         'email' => $i == 0 ? 'admin@demo.com' : $faker->email(),
        //         'nis' => $selected_level == 'siswa' ? '1000'.rand(100, 999).'000123'.rand(100, 999) : null,
        //         'nip' => $selected_level == 'guru' ? '100'.rand(100, 999).'0000956'.rand(100, 999) : null,
        //         'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
        //         'tanggal_lahir' => $faker->dateTimeBetween(Carbon::now()->subYears(45)->format('d-m-Y'), Carbon::now()->subYears(10)->format('d-m-Y'))->format('d-m-Y'),
        //         'tempat_lahir' => $faker->address(),
        //         'status_guru' => $selected_level == 'guru' ? $status_guru[rand(1,2)] : 'bukan_guru',
        //         'pekerjaan' => $selected_level == 'ortu' ? $faker->jobTitle() : null,
        //         'no_telp' => $faker->e164PhoneNumber(),
        //         'alamat' => $faker->address(),
        //         'status' => 'aktif',
        //         'level' => $selected_level,
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now(),
        //     ];
            
        //     $this->user->updateOrInsert(['email' => $data['email']], $data);
        // }
    }
}