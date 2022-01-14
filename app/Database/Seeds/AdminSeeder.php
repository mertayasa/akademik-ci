<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\AdminModel;
use CodeIgniter\Commands\Utilities\Publish;

class AdminSeeder extends Seeder
{
    protected $admin;

    public function __construct()
    {
        $this->admin = new AdminModel();
    }
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $data = [
            'nama' => $faker->name(),
            'email' => 'admin@demo.com',
            'password' => password_hash('asdasdasd', PASSWORD_DEFAULT),
            'status' => 'aktif'
        ];
        $this->admin->updateOrInsert(['email' => $data['email']], $data);
    }
}
